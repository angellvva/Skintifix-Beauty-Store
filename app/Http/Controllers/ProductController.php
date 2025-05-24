<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // Added Auth import
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function detail($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);

        $isInWishlist = false;

        $userId = Auth::id();  // Use Auth here

        if ($userId) {
            $isInWishlist = \App\Models\Wishlist::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();
        }

        $isBestSeller = OrderItem::where('product_id', $product->id)
            ->where('quantity', '>', 1)
            ->exists();

        $isNewArrival = $product->created_at->gt(now()->subDays(30));

        return view('product-detail', compact('product', 'isBestSeller', 'isNewArrival', 'isInWishlist'));
    }

    public function categoryCatalog($category, Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status', 'all');
        $sort = $request->query('sort', 'newest');

        $productsQuery = Product::with('category')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            });

        // Search by product name
        if ($search) {
            $productsQuery->where('name', 'like', '%' . $search . '%');
        }

        // Filter by stock status
        if ($status == 'in_stock') {
            $productsQuery->where('stock', '>', 0); // sesuaikan field `stock` di DB
        } elseif ($status == 'out_of_stock') {
            $productsQuery->where('stock', '=', 0);
        }

        // Sorting
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $productsQuery->orderBy('created_at', 'desc');
                break;
        }

        $products = $productsQuery->get();
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
