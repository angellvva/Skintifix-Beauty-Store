<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class WishlistController extends Controller
{
    //
    public function Wishlist()
    {
        $userId = session('id_cust', Cookie::get('id_cust'));

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
        $userId = session('id_cust', Cookie::get('id_cust'));

        if (!$userId) {
            return redirect()->route('login')->with('error', "Please log in first.");
        }

        DB::table('wishlists')
            ->where('product_id', $productId)
            ->where('user_id', $userId)
            ->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }
}
