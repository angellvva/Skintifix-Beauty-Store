<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class HomeController extends Controller
{
    //
    public function show() {
        return view('home',[
            'product_categories'=>ProductCategory::with(['products'])->get()
        ]);
    }

    public function allProducts()
    {
        $products = Product::all(); // Or paginate(12) if needed
        return view('catalog', compact('products'));
    }

    public function addToCart($id, Request $request)
{
    $product = Product::findOrFail($id);
    $user = Auth::user();

    // Check if this product is already in user's cart
    $cartItem = Cart::where('id', $user->id)
                    ->where('product_id', $id)
                    ->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        Cart::create([
            'id' => $user->id,
            'product_id' => $id,
            'quantity' => 1,
        ]);
    }

    return back()->with('success', 'Product added to cart!');
}

public function addToWishlist($id)
{
    $product = Product::findOrFail($id);
    $userId = session('id'); // atau session('id_cust') jika kamu konsisten pakai itu

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $exists = Wishlist::where('user_id', $userId)
                        ->where('product_id', $id)
                        ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $id,
            ]);
        }

    return back()->with('success', 'Product added to wishlist!');
}

public function viewCart()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart'));
    }

public function viewWishlist()
    {
        $wishlist = session('wishlist', []);
        return view('wishlist', compact('wishlist'));
    }
}
