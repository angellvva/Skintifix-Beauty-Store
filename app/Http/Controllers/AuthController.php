<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan form lupa password
    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');
    }

    // Mengirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);

        Session::put('otp_email', $request->email);
        Session::put('otp_code', $otp);
        Session::put('otp_expires_at', now()->addMinutes(10));

        Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
            $message->to($request->email)->subject('Your OTP Code');
        });

        return redirect()->route('verify.otp.form')->with('email', $request->email);
    }

    // Menampilkan form input OTP
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if (!Session::has('otp_code') || !Session::has('otp_expires_at')) {
            return back()->withErrors(['otp' => 'OTP session expired. Please request a new OTP.']);
        }

        if (Session::get('otp_code') != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        if (now()->greaterThan(Session::get('otp_expires_at'))) {
            return back()->withErrors(['otp' => 'OTP has expired. Please request a new OTP.']);
        }

        return redirect()->route('password.reset.form')->with('email', Session::get('otp_email'));
    }

    // Resend OTP
    public function resendOtp()
    {
        if (!Session::has('otp_email')) {
            return redirect()->route('forget.password.form')->withErrors(['email' => 'Email session expired. Please try again.']);
        }

        $email = Session::get('otp_email');
        $otp = rand(100000, 999999);

        Session::put('otp_code', $otp);
        Session::put('otp_expires_at', now()->addMinutes(10));

        Mail::raw("Your new OTP code is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Your New OTP Code');
        });

        return redirect()->route('verify.otp.form')->with([
            'email' => $email,
            'status' => 'A new OTP has been sent to your email.'
        ]);
    }

    // Menampilkan form reset password
    public function showResetPasswordForm()
    {
        return view('auth.reset-password');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Find the user by email
        $user = User::where('email', $request->email)->first();
        
        // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Clear OTP session data
        Session::forget(['otp_email', 'otp_code', 'otp_expires_at']);

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('status', 'Password reset successful! Please log in.');
    }

    // Menampilkan form registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    //Menangani proses registrasi
    public function register(Request $request)
    {
        // Validasi data yang dimasukkan
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|digits_between:10,15',
        'email' => 'required|string|email|max:255|unique:users',
        'address' => 'required|string|min:5|max:255',
        'postal_code' => 'required|string|max:10',
        'city' => 'required|string|max:100',
        'country' => 'required|string|max:100',
        'password' => 'required|string|confirmed|min:8',
    ]);

        // Concatenate address, city, postal code, and country
        $full_address = $validated['address'] . ', ' . $validated['postal_code'] . ', ' . $validated['city'] . ', ' . $validated['country'];

        // Membuat pengguna baru
        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $full_address,
            'password' => Hash::make($validated['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Redirect setelah registrasi berhasil
        return redirect()->route('login')->with('status', 'Registration successful! Please login.');
    }
    

    public function login(Request $request)
{
    // Validasi email dan password
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Ambil kredensial email dan password
    $credentials = $request->only('email', 'password');

    // Cek apakah login berhasil menggunakan Auth::attempt
    if (Auth::attempt($credentials)) {
        // Jika berhasil login, redirect ke halaman yang dituju
        return redirect()->intended('/');
    }

    // Debugging: Cek apakah email ada di database
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak ditemukan']);
    }

    // Debugging: Cek apakah password yang dimasukkan cocok dengan yang ada di database
    if (Hash::check($request->password, $user->password)) {
        // Jika password cocok, lanjutkan login
        Auth::loginUsingId($user->id);
        return redirect()->intended('/');
    }

    // Jika password salah
    return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
}


public function logout(Request $request)
{
    Auth::logout();  // Logout pengguna
    $request->session()->invalidate();  // Hapus session
    $request->session()->regenerateToken();  // Regenerasi token CSRF

    return redirect()->route('login');  // Kembali ke halaman login
}

}
