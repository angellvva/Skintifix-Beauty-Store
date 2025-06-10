<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        // Filter dan hapus item cart jika product-nya sudah tidak ada
        $validCartItems = $cartItems->filter(function ($item) {
            if (!$item->product) {
                // Produk sudah dihapus, maka item keranjang juga dihapus
                $item->delete();
                return false;
            }
            return true;
        });

        return view('cart', ['cartItems' => $validCartItems]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::findOrFail($id);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['message' => 'Cart updated successfully.']);
    }

    public function remove($id)
    {
        Cart::findOrFail($id)->delete();

        return redirect()->route('cart.view')->with('success', 'Product removed from cart.');
    }
}
