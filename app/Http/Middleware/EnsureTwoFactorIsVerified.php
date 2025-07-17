<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class EnsureTwoFactorIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // If not logged in or no 2FA code is set, let Laravel handle it elsewhere
        if (!$user) {
            return redirect()->route('home');
        }

        // If user has no 2FA active or already cleared 2FA, allow access
        if (is_null($user->two_factor_code) && is_null($user->two_factor_expires_at)) {
            return $next($request);
        }

        // Check for remembered device cookie
        $cookieName = "remember_2fa_{$user->id}";
        $remembered = $request->cookie($cookieName);

        if ($remembered && $remembered === hash('sha256', $user->id . $user->email)) {
            return $next($request);
        }

        // Otherwise, redirect to 2FA verification page
        return redirect()->route('home')->with('message','Two factor verification failed!');
    }
}

