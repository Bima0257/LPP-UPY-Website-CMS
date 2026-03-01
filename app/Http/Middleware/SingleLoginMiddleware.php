<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SingleLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $currentSessionId = session()->getId();
            $now = time();
            $lifetime = config('session.lifetime') * 60;

            // Ambil semua session milik user
            $sessions = DB::table('sessions')->where('user_id', $userId)->get();

            foreach ($sessions as $session) {
                if (($now - $session->last_activity) > $lifetime) {
                    // Hapus session expired untuk menghindari logout keliru
                    DB::table('sessions')->where('id', $session->id)->delete();
                }
            }

            // Cek ulang setelah expired dibersihkan
            $stillActive = DB::table('sessions')
                ->where('user_id', $userId)
                ->where('id', '!=', $currentSessionId)
                ->count();

            if ($stillActive > 0) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->with('loginError', 'Akun ini sedang digunakan di perangkat lain!');
            }
        }

        return $next($request);
    }
}
