<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExtendSessionOnActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && config('session.driver') === 'database') {

            $sessionId = $request->session()->getId();
            $now = time();
            $lifetime = config('session.lifetime') * 60; // detik

            $session = DB::table('sessions')->where('id', $sessionId)->first();

            if ($session && ($now - $session->last_activity) > ($lifetime / 2)) {
                DB::table('sessions')
                    ->where('id', $sessionId)
                    ->update([
                        'last_activity' => $now,
                    ]);
            }
        }

        return $next($request);
    }
}
