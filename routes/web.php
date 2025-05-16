<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\WishlistController;

// ROUTE HOME
// Route::get('/', function () {return view('home');});
Route::get('/', [HomeController::class, 'show'])
->name('home');

// route untuk cart
// Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{id}', [HomeController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.view');
Route::put('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// route untuk catalog
Route::get('/catalog', [HomeController::class, 'allProducts'])
->name('catalog');

// ROUTE PASSWORD RESET
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
Route::post('/wishlist/add/{id}', [HomeController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'Wishlist'])->name('wishlist.view');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');

//Route contact
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store']);

//checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

// Login Routes
Route::get('/login', [App\Http\Controllers\LoginController::class, 'Login'])->name('login');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'LoginAction'])->name('login');
// Logout Route
Route::post('/logout', [App\Http\Controllers\LoginController::class, 'Logout'])->name('logout');


// Route untuk menampilkan form register
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route untuk menangani registrasi pengguna
Route::post('register', [AuthController::class, 'register'])->name('register.submit');