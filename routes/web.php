<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
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

// // route untuk cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// route untuk catalog
Route::get('/catalog', [HomeController::class, 'allProducts'])
->name('catalog');

// route untuk login
Route::get('/login', function (){
    return view('auth.login');
})->name('login');

// route untuk contact
Route::get('/contact', function (){
    return view('contact');
})->name('contact');

// Route untuk menampilkan form forgot password
Route::get('forget-password', [PasswordController::class, 'showForgotPasswordForm'])
->name('forget-password');

// Route untuk mengirim permintaan reset password
Route::post('forget-password', [PasswordController::class, 'sendResetLinkEmail'])
->name('password.email');

// Route untuk menampilkan form reset password
Route::get('reset-password/{token}', [PasswordController::class, 'showResetForm'])
->name('password.reset');

// Route untuk menangani pengaturan ulang password
Route::post('reset-password', [PasswordController::class, 'reset'])
->name('password.update');

//Route untuk button add cart dan wishlist di product page
Route::post('/cart/add/{id}', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/wishlist/add/{id}', [HomeController::class, 'addToWishlist'])->name('wishlist.add');

Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);