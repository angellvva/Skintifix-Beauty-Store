<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;

// ROUTE PASSWORD RESET
// Route untuk menampilkan form forgot password
Route::get('/forget-password', [PasswordController::class, 'showForgetPasswordForm'])
    ->name('forget-password');

// Route untuk mengirim permintaan reset password
Route::post('/forget-password', [PasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// Route untuk menampilkan form reset password
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])
    ->name('password.reset');

// Route untuk menangani pengaturan ulang password
Route::post('/reset-password', [PasswordController::class, 'reset'])
    ->name('password.update');

// Login Routes
Route::get('/login', [LoginController::class, 'Login'])->name('login'); // form view
Route::post('/login', [LoginController::class, 'LoginAction'])->name('login.action'); // form submit

// Logout Route
Route::post('/logout', [LoginController::class, 'Logout'])->name('logout');

// Route untuk menampilkan form register
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route untuk menangani registrasi pengguna
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::middleware(['auth', 'is_admin'])->group(function () {
    // route admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // route admin product
    Route::get('/admin/products', [AdminProductController::class, 'products'])->name('admin.products');
    // route admin add product
    Route::get('/admin/add-product', [AdminProductController::class, 'add_product'])->name('admin.add-product');
    // route admin delete product
    Route::post('/admin/delete-product', [AdminProductController::class, 'delete_product'])->name('admin.delete-product');

    // route admin order
    Route::get('/admin/orders', [AdminOrderController::class, 'orders'])->name('admin.orders');

    // route admin customer
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    // route admin messages
    Route::get('/admin/messages', [AdminController::class, 'messages'])->name('admin.messages');

    //Order view admin
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

    // Route untuk edit order
    Route::get('/orders/{id}/edit', [AdminOrderController::class, 'edit'])->name('orders.edit');
    Route::put('/admin/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');

    Route::resource('admin/categories', CategoryController::class)->names([
        'index' => 'admin.categories',
        'store' => 'categories.store',
        'destroy' => 'categories.destroy',
    ]);

    Route::get('/admin/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    Route::post('/category/remove', [CategoryController::class, 'removeCategory'])->name('category.remove');

    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
});

Route::middleware(['auth', 'is_user'])->group(function () {
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
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');


    // route untuk catalog
    Route::get('/catalog', [HomeController::class, 'allProducts'])
        ->name('catalog');

    //Route untuk button add cart dan wishlist di product page
    Route::post('/wishlist/add/{id}', [HomeController::class, 'addToWishlist'])->name('wishlist.add');
    Route::get('/wishlist', [WishlistController::class, 'Wishlist'])->name('wishlist.view');
    Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
    Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    //Route contact
    Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
    Route::post('/contact', [ContactController::class, 'store']);

    //checkout
    Route::post('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // Route untuk menampilkan best seller products
    Route::get('/best-seller', [HomeController::class, 'viewBestSeller'])
        ->name('best-seller');

    // Route untuk menampilkan new arrival products
    Route::get('/new-arrival', [HomeController::class, 'viewNewArrival'])
        ->name('new-arrival');

    // Route untuk menampilkan product details
    Route::get('/product/{id}', [ProductController::class, 'detail'])
        ->name('product.detail');

    // Route untuk menampilkan product berdasarkan category
    Route::get('/catalog/{category}', [ProductController::class, 'categoryCatalog'])
        ->name('category.catalog');

    // Route untuk ke view edit profile saat pencet button edit profile
    Route::get('/edit-profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/edit-profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    // route my orders
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my-orders');

    //Route untuk create review
    Route::get('/products/{id}/review', [ReviewController::class, 'create'])->name('reviews.create');
    // Handle the review form submission
    Route::post('/products/{id}/review', [ReviewController::class, 'store'])->name('reviews.store');

    //Checkout selected items
    Route::post('/checkout/selected', [CheckoutController::class, 'checkoutSelected'])->name('checkout.selected');

    // Single route for both showing and tracking orders
    Route::get('/order/{order_id}', [OrderController::class, 'order_detail'])->name('order.detail'); // Show or track order

    // Route for canceling the order
    Route::get('/order/cancel/{order_id}', [OrderController::class, 'cancel'])->name('order.cancel'); // Cancel order

    //Route buat search bar
    Route::get('/search/products', [ProductController::class, 'search'])->name('search.products');

    // Route buat payment-success
    Route::get('/payment-success', function () {
        $payment = (object) [
            'id' => 123,
            'created_at' => now(),
            'total_amount' => 149000,
            'status' => 'paid',
        ];

        return view('payment-success', compact('payment'));
    })->name('payment.success');
});
