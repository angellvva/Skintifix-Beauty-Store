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

        // Best Seller Products (sama dengan best-seller view)
        $topSelling = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        $productIds = $topSelling->pluck('product_id');

        $products = Product::with('category')->whereIn('id', $productIds)->get()->keyBy('id');

        $wishlistProductIds = $userId
            ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray()
            : [];

        // Gabungkan info best seller
        $order_items = $topSelling->map(function ($item) use ($products, $wishlistProductIds) {
            return (object) [
                'product' => $products[$item->product_id] ?? null,
                'total_sold' => $item->total_sold,
                'isInWishlist' => in_array($item->product_id, $wishlistProductIds),
            ];
        })->filter(fn($i) => $i->product !== null);

        // All Products
        $productsAll = Product::with(['category'])->get();
        foreach ($productsAll as $product) {
            $product->isInWishlist = in_array($product->id, $wishlistProductIds);
        }

        // New Arrivals
        $order_itemss = OrderItem::where('quantity', '>', 0)
            ->with(['product', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        foreach ($order_itemss as $item) {
            $item->isInWishlist = in_array($item->product_id, $wishlistProductIds);
        }

        return view('home', [
            'order_items' => $order_items,
            'products' => $productsAll,
            'order_itemss' => $order_itemss
        ]);
    }

    public function viewBestSeller()
    {
        $userId = Auth::id();

        // Ambil 8 produk dengan jumlah unit terjual terbanyak
        $topSelling = OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(8)
            ->get();

        $productIds = $topSelling->pluck('product_id');

        $products = Product::with('category')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        // Ambil wishlist user
        $wishlistProductIds = $userId
            ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray()
            : [];

        // Gabungkan semua info dalam array final
        $bestSellerItems = $topSelling->map(function ($item) use ($products, $wishlistProductIds) {
            return (object) [
                'product' => $products[$item->product_id] ?? null,
                'total_sold' => $item->total_sold,
                'isInWishlist' => in_array($item->product_id, $wishlistProductIds),
            ];
        })->filter(fn($i) => $i->product !== null);

        return view('best-seller', ['order_items' => $bestSellerItems]);
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

        $wishlistProductIds = $userId ? Wishlist::where('user_id', $userId)->pluck('product_id')->toArray() : [];

        $productsQuery = Product::with('category');

        // Paginate 8 per page, urutkan berdasarkan stok
        $productsPaginated = $productsQuery->orderByRaw("stock > 0 DESC")
            ->paginate(8);

        foreach ($productsPaginated as $product) {
            $product->isInWishlist = in_array($product->id, $wishlistProductIds);
        }

        return view('catalog', ['products' => $productsPaginated]);
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
