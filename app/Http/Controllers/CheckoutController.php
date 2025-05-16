<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    public function index()
    {
        // Bisa tambahkan data atau logika di sini jika perlu, misal data order, user, dll.
        return view('checkout'); // Pastikan file checkout.blade.php ada di resources/views
    }

    public function showCheckout(Request $request)
    {
        $selectedIds = $request->input('selected_items', []);

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Please select at least one product to checkout.');
        }

        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->whereIn('carts.id', $selectedIds)
            ->select(
                'carts.id as cart_id',
                'products.name',
                'products.price',
                'products.image',
                'carts.quantity'
            )
            ->get();

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item->price * $item->quantity;
        }

        $userId = session('id') ?? Cookie::get('id');
        $user = DB::table('users')->where('id', $userId)->first();

        return view('checkout', compact('cartItems', 'cartTotal', 'user'));
    }

    public function process(Request $request) {
        // Validate and store checkout data

        // Redirect to payment gateway (placeholder for now)
        return redirect()->away('https://payment-gateway-placeholder.com');
    }
}
