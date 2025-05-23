<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function show()
    {
        $userId = Auth::id();

        // Best Sellers
        $order_items = OrderItem::where('quantity', '>', 1)
            ->with(['product', 'category'])
            ->get();

        // All Products
        $products = Product::with(['category'])->get();

        // New Arrivals
        $order_itemss = OrderItem::where('quantity', '>', 0)
            ->with(['product', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // Wishlist data
        $wishlistProductIds = $userId ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray() : [];

        foreach ($order_items as $item) {
            $item->isInWishlist = in_array($item->product_id, $wishlistProductIds);
        }

        foreach ($products as $product) {
            $product->isInWishlist = in_array($product->id, $wishlistProductIds);
        }

        foreach ($order_itemss as $item) {
            $item->isInWishlist = in_array($item->product_id, $wishlistProductIds);
        }

        return view('home', compact('order_items', 'products', 'order_itemss'));
    }

    public function viewBestSeller()
    {
        $userId = Auth::id();

        $order_items = OrderItem::where('quantity', '>', 1)
            ->with(['product'])
            ->get();

        $wishlistProductIds = $userId ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray() : [];

        foreach ($order_items as $product) {
            $product->isInWishlist = in_array($product->product_id, $wishlistProductIds);
        }

        return view('best-seller', compact('order_items'));
    }

    public function viewNewArrival()
    {
        $userId = Auth::id();

        $order_items = OrderItem::where('quantity', '>', 0)
            ->with(['product', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $wishlistProductIds = $userId ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray() : [];

        foreach ($order_items as $product) {
            $product->isInWishlist = in_array($product->product_id, $wishlistProductIds);
        }

        return view('new-arrival', compact('order_items'));
    }

    public function allProducts()
    {
        $userId = Auth::id();
        $products = Product::with('category')->get();

        $wishlistProductIds = $userId ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray() : [];

        foreach ($products as $product) {
            $product->isInWishlist = in_array($product->id, $wishlistProductIds);
        }

        return view('catalog', compact('products'));
    }

    public function addToCart($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $id,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function addToWishlist($id)
    {
        $userId = Auth::id();

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
        $userId = Auth::id();

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