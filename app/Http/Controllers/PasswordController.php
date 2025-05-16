<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    // Show the form to reset the password (no token needed)
    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');  // Directly show the reset password form
    }

    // Handle the password reset (without email or token validation)
    public function reset(Request $request)
    {
        // Validate the request (email and new password)
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user by email
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        // Update the user's password
        $user->password = Hash::make($validated['password']);
        $user->save();

        // Redirect to login page with success message
        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
}
