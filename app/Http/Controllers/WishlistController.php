<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function Wishlist()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login')->with('error', "Please log in first.");
        }

        $wishlistProducts = Product::whereIn('id', function ($query) use ($userId) {
        $query->select('product_id')
              ->from('wishlists')
              ->where('user_id', $userId);
    })->get();

    // Set isInWishlist = true manually for view rendering
    foreach ($wishlistProducts as $product) {
        $product->isInWishlist = true;
    }
    
        return view('wishlist', compact('wishlistProducts'));
    }

    public function removeFromWishlist(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->input('product_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', "Please log in first.");
        }

        DB::table('wishlists')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }

    public function toggle(Request $request, $productId)
    {
        $userId = Auth::id();

        if (!$userId) {
            // you can redirect or return back with error message
            return back()->with('error', 'You need to log in first.');
        }

        $wishlistItem = Wishlist::where('user_id', $userId)
                                ->where('product_id', $productId)
                                ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            return back()->with('success', 'Removed from wishlist!');
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return back()->with('success', 'Added to wishlist!');
        }
    }
}
