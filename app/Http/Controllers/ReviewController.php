<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($productId)
    {
        $product = Product::findOrFail($productId);
        return view('review-create', compact('product'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id' => $productId,
            'user_id' => session('id'),
            //Auth::id(), // Will be null if not logged in
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('product.detail', $productId)->with('success', 'Review submitted!');
    }
}
