<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    //
    public function Wishlist()
    {
        $userId = session('id', Cookie::get('id'));

        if (!$userId) {
            return redirect()->route('login')->with('error', "Please log in first.");
        }

        $wishlistProducts = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->where('wishlists.user_id', $userId)
            ->select('products.id', 'products.name', 'products.price', 'products.image')
            ->get();

        return view('wishlist', compact('wishlistProducts'));
    }

    public function removeFromWishlist(Request $request)
    {
        $productId = $request->input('product_id');
        $userId = session('id', Cookie::get('id'));

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
        $userId = session('id'); // or whatever key you use to store the logged-in user

        if (!$userId) {
            return back()->with('success', 'You need to log in first.');
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
