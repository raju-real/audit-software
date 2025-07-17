<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public function show()
    {
        return view('admin.auth.2fa_verify'); // Create this Blade file
    }

    public function verify(Request $request)
    {
        //return $request;
        // If code passed as 1 - 2 - 3 - 4 -5 -6
        $request->merge([
            'two_factor_code' => preg_replace('/\D/', '', $request->input('two_factor_code'))
        ]);

        $request->validate([
            'two_factor_code' => ['required', 'digits:6'],
            'remember_device' => 'nullable',
        ]);
        
        $user = auth()->user();

        if ($user->two_factor_code !== $request->two_factor_code || Carbon::parse($user->two_factor_expires_at)->isPast()) {
            return redirect()->back()->with('message', 'Invalid or expired code.');
        }

        // Clear 2FA
        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        // Set "remember device" cookie
        if ($request->has('remember_device')) {
            $cookie = cookie(
                "remember_2fa_{$user->id}",
                hash('sha256', $user->id . $user->email),
                60 * 24 * 30 // 30 days
            );

            return redirect()->intended(route('admin.dashboard'))->withCookie($cookie);
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
