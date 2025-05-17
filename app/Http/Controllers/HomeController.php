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
            'order_items'=>OrderItem::where('quantity', '>', 1)
            ->with(['product', 'category'])
            ->get(),

            'products'=>Product::with(['category'])
            ->get(),

            'order_itemss'=>OrderItem::where('quantity', '>', 0)
            ->with(['product', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
        ]);
    }

    public function viewBestSeller() {
        return view('best-seller',[
            'order_items'=>OrderItem::where('quantity', '>', 1)
            ->with(['product'])
            ->get()
        ]);
    }

    public function viewNewArrival() {
        return view('new-arrival', [
            'order_items'=>OrderItem::where('quantity', '>', 0)
            ->with(['product', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
        ]);
    }

    public function allProducts()
    {
        $userId = session('id'); // or Auth::id() if you're using authentication
        $products = Product::with('category')->get();

        // If user is logged in, mark each product as in wishlist or not
        if ($userId) {
            $wishlistProductIds = Wishlist::where('user_id', $userId)
                                        ->pluck('product_id')
                                        ->toArray();

            foreach ($products as $product) {
                $product->isInWishlist = in_array($product->id, $wishlistProductIds);
            }
        } else {
            foreach ($products as $product) {
                $product->isInWishlist = false;
            }
        }

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

public function toggleWishlist($id)
{
    $userId = session('id');

    if (!$userId) {
        return redirect()->route('login')->with('error', 'Please login first');
    }

    $wishlistItem = Wishlist::where('user_id', $userId)
                            ->where('product_id', $id)
                            ->first();

    if ($wishlistItem) {
        $wishlistItem->delete();
        return back()->with('success', 'Product removed from wishlist!');
    } else {
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $id,
        ]);
        return back()->with('success', 'Product added to wishlist!');
    }
}
}
