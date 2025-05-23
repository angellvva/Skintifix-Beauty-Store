<?php

namespace App\Http\Controllers; // pastikan namespace ini ada

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        $userId = session('id', Cookie::get('id'));

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(
                'carts.id as cart_id',
                'products.name',
                'products.price',
                'products.image',
                'products.description',
                'carts.quantity'
            )
            ->get();

        return view('cart', compact('cartItems'));
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

    public function updateQuantity(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        DB::table('carts')
            ->where('id', $id)
            ->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Quantity updated successfully.']);
    }

    public function remove($id)
    {
        DB::table('carts')->where('id', $id)->delete();

        return redirect()->route('cart.view')->with('success', 'Product removed from cart.');
    }
}
