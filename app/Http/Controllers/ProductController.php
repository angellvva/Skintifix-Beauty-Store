<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

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
        // Eager load category relation
        $products = Product::with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            })
            ->get();

        // Get category description from first product
        $categoryDescription = optional($products->first()?->category)->description;

        return view('category-catalog', compact('products', 'category', 'categoryDescription'));
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $category = $request->category;

        $products = Product::with('category')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category, function ($q) use ($category) {
                $q->whereHas('category', function ($c) use ($category) {
                    $c->where('name', $category);
                });
            })
            ->limit(10)
            ->get();

        $result = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => Str::limit($product->description, 60),
                'category' => $product->category->name ?? 'Uncategorized',
                'image' => $product->image
            ];
        });

        return response()->json($result);
    }
}
