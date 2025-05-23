<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    //
    public function Login()
    {
        return view('auth.login');
    }

    public function LoginAction(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek login sebagai admin (hardcoded)
        if (
            $request->email === 'admin@admin.com' &&
            $request->password === 'adminadmin'
        ) {
            session([
                'is_admin' => true,
                'email' => $request->email,
                'name' => 'Admin',
            ]);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        // Find user from 'users' table
        $user = DB::table('users')->where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect('/login')->withErrors(['email' => 'Email not registered in database'])->withInput();
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return redirect('/login')->withErrors(['password' => 'Your Password Incorrect'])->withInput();
        }

        // Simpan sesi
        if ($request->has('remember')) {
            Cookie::queue('id', $user->id, 60 * 24 * 7);
            Cookie::queue('email', $user->email, 60 * 24 * 7);
            Cookie::queue('name', $user->name, 60 * 24 * 7);
        } else {
            session()->put('id', $user->id);
            session()->put('email', $user->email);
            session()->put('name', $user->name);
        }
        return redirect('/')->with('success', 'Login Successful!');
    }   
}
