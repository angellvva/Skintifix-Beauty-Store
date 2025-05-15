<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

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

    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
            "image" => $product->image
        ];
    }

    session()->put('cart', $cart);
    return back()->with('success', 'Product added to cart!');
}

public function addToWishlist($id)
{
    $product = Product::findOrFail($id);

    $wishlist = session()->get('wishlist', []);

    $wishlist[$id] = [
        "name" => $product->name,
        "price" => $product->price,
        "image" => $product->image
    ];

    session()->put('wishlist', $wishlist);
    return back()->with('success', 'Product added to wishlist!');
}
}
