<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    //
    public function show() {
        return view('home',[
            'order_items'=>OrderItem::where('quantity', '>', 0)
            ->with(['product'])
            ->get(),

            'products'=>Product::where('created_at', '>=', now()->subDays(7))
            ->get()
        ]);
    }

    public function viewBestSeller() {
        return view('best-seller',[
            'order_items'=>OrderItem::where('quantity', '>', 0)
            ->with(['product'])
            ->get()
        ]);
    }

    public function viewNewArrival() {
        return view('new-arrival', [
            'products'=>Product::where('created_at', '>=', now()->subDays(7))
            ->get()
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
    // $user = Auth::user();
    $user = session('id', Cookie::get('id'));

    // Check if this product is already in user's cart
    $cartItem = Cart::where('user_id',$user)
                    ->where('product_id', $id)
                    ->first();

    if ($cartItem) {
        $cartItem->quantity += 1;
        $cartItem->save();
    } else {
        Cart::create([
            'user_id' => $user,
            'product_id' => $id,
            'quantity' => 1,
        ]);
    }

    return back()->with('success', 'Product added to cart!');
}

public function addToWishlist($id)
{
    $product = Product::findOrFail($id);
    $userId = session('id');

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
