<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function Login()
    {
        return view('auth.login');
    }

    public function LoginAction(Request $request)
    {
        // Validate login form
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login using Laravel Auth
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Redirect based on email (or roles if used)
            if (Auth::user()->email === 'admin@admin.com') {
                session(['is_admin' => true]);
                return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
            }

            return redirect()->route('home')->with('success', 'Login successful!');
        }

        // If login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Cookie::queue(Cookie::forget(Auth::getRecallerName())); // Clear remember me cookie

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}