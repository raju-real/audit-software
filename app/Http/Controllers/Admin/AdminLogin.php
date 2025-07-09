<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            auth()->user()->update(['last_login_at' => now()]);
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()
            ->back()
            ->withInput($request->only('email', 'remember'))
            ->with('danger', 'Email or Password not matched!');
    }
}
