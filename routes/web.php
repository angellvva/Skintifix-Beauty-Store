<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    return view('home');
});

Route::get('/', [HomeController::class, 'show'])
->name('home');

// route untuk wishlist
Route::get('/wishlist', function () {
    return view('wishlist');
})->name('wishlist');

// route untuk cart
Route::get('/cart', function () {
    return view('cart');
})->name('cart');

// route untuk login
Route::get('/login', function (){
    return view('auth.login');
})->name('login');

// Route untuk menampilkan form forgot password
Route::get('forgot-password', [PasswordController::class, 'showForgotPasswordForm'])
->name('password.request');

// Route untuk mengirim permintaan reset password
Route::post('forgot-password', [PasswordController::class, 'sendResetLinkEmail'])
->name('password.email');

// Route untuk menampilkan form reset password
Route::get('reset-password/{token}', [PasswordController::class, 'showResetForm'])
->name('password.reset');

// Route untuk menangani pengaturan ulang password
Route::post('reset-password', [PasswordController::class, 'reset'])
->name('password.update');
