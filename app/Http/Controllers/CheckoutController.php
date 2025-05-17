<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Midtrans\Snap;
use Midtrans\Config;

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

    public function process(Request $request)
    {
        // Prepare Midtrans config
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Calculate subtotal from cart items (replace with your logic)
        $cartItems = // get user cart items here
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        // Get shipping cost from request (you sent it from frontend)
        $shippingCost = 0;
        if ($request->shipping_method == 'standard') {
            $shippingCost = 20000;
        } elseif ($request->shipping_method == 'express') {
            $shippingCost = 40000;
        }

        $totalAmount = $subtotal + $shippingCost;

        // Prepare transaction details for Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id' => uniqid(), // generate unique order id
                'gross_amount' => $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'phone' => $request->phone,
                'address' => [
                    'address' => $request->address,
                    'postal_code' => $request->postal_code,
                    'city' => $request->region,
                    'country_code' => $request->country,
                ],
            ],
            'item_details' => $cartItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->name,
                ];
            })->toArray(),
        ];

        // Get Snap payment URL (token)
        $snapToken = Snap::getSnapToken($params);

        // Return to frontend with snap token
        return response()->json(['snap_token' => $snapToken]);
    }
}
