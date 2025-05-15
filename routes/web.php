<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
