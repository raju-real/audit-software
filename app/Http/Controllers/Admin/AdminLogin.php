<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TrustedDevice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\TwoFactorSmsService;

class AdminLogin extends Controller
{
    public function __invoke(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => 'active',
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            $user = auth()->user();

            // Update login time
            $user->update(['last_login_at' => now()]);

            // Check if device is remembered
            if ($this->deviceIsRemembered($request, $user)) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // Trigger 2FA
            $user->two_factor_code = rand(100000, 999999);
            $user->two_factor_expires_at = now()->addMinutes(10);
            $user->save();

            // Send 2FA code via email or SMS here
            // Mail::to($user)->send(new TwoFactorCodeMail($user));

            return redirect()->route('admin.2fa.verify');
        }

        return redirect()
            ->back()
            ->withInput($request->only('email', 'remember'))
            ->with('message', 'Email or Password not matched!');
    }

    protected function deviceIsRemembered(Request $request, $user): bool
    {
        $cookie = $request->cookie("remember_2fa_{$user->id}");

        return $cookie === hash('sha256', $user->id . $user->email);
    }
}
