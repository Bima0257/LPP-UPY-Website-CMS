<?php

namespace App\Http\Controllers;

use App\Models\Abouts;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        return view('admin.auth.index', [
            'about' => Abouts::select('black_logo', 'favicon')->first(),
            'title' => 'Login | Admin-LPP'
        ]);
    }

    public function authenticate(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $key = 'login.' . $request->username . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('loginError', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.");
        }

        if (!Auth::attempt($credentials)) {
            RateLimiter::hit($key, 60);
            return back()->with('loginError', 'Username atau password salah!');
        }

        // Clear rate limiter saat login berhasil
        RateLimiter::clear($key);

        $user = Auth::user();

        $request->session()->regenerate();

        DB::table('sessions')
            ->where('id', session()->getId())
            ->update(['user_id' => $user->id]);


        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId())
            ->delete();


        if (in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->intended('/dashboard');
        }

        Auth::logout();
        return redirect('/login')->with('loginError', 'Anda tidak memiliki akses!');
    }


    public function logout(Request $request)
    {
        // hapus session user di database
        DB::table('sessions')->where('user_id', Auth::id())->delete();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
