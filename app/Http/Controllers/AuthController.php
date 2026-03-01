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
            'username' => 'required',
            'password' => 'required'
        ]);

        // Rate limiting - maksimal 5 percobaan per 1 menit
        $key = 'login.' . $request->ip();
        $maxAttempts = 5;
        $decayMinutes = 1;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('loginError', "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.");
        }

        if (!Auth::attempt($credentials)) {
            // Tambahkan hit ke rate limiter saat login gagal
            RateLimiter::hit($key, $decayMinutes * 60);

            $attemptsLeft = $maxAttempts - RateLimiter::attempts($key);

            if ($attemptsLeft > 0) {
                return back()->with('loginError', "Username atau password salah!");
            } else {
                return back()->with('loginError', 'Terlalu banyak percobaan login. Akun diblokir sementara.');
            }
        }

        // Clear rate limiter saat login berhasil
        RateLimiter::clear($key);

        $user = Auth::user();

        // Hapus sesi expired sebelum cek session lain
        DB::table('sessions')
            ->where('last_activity', '<', now()->subMinutes(config('session.lifetime'))->timestamp)
            ->delete();

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Update session milik user ini
        DB::table('sessions')
            ->where('id', session()->getId())
            ->update([
                'user_id' => $user->id,
            ]);

        // Cek apakah ada session lain aktif selain session ini
        $activeSession = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', session()->getId())
            ->first();

        if ($activeSession) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->with('loginError', 'Akun ini sedang digunakan pada perangkat lain!');
        }

        // Cek role
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->intended('/dashboard');
        }

        // Logout jika bukan role yang diizinkan
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
