<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\OrderItem;

class ProductController extends Controller
{
    //
    public function detail($id)
    {
        // Load product with reviews and user relations
        $product = Product::with('reviews.user')->findOrFail($id);

        $isInWishlist = false;

        // Get user id from session
        $userId = session('id');

        // If user id exists, check if wishlist record exists for this product and user
        if ($userId) {
            $isInWishlist = \App\Models\Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();
        }

        // Check if product is best seller (quantity > 1 in order_items)
        $isBestSeller = OrderItem::where('product_id', $product->id)
            ->where('quantity', '>', 1)
            ->exists();

        // Check if product is new arrival (created in last 30 days)
        $isNewArrival = $product->created_at->gt(now()->subDays(30));

        // Pass the flags to the view
        return view('product-detail', compact('product', 'isBestSeller', 'isNewArrival', 'isInWishlist'));
    }

    public function categoryCatalog($category)
    {
        $products = Product::whereHas('category', function($query) use ($category) {
            $query->where('name', $category);
        })->get();

        return view('category-catalog', compact('products', 'category'));
    }
}