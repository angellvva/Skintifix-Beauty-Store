<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\CartItem;


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

        if (is_string($selectedIds)) {
            $selectedIds = explode(',', $selectedIds);
        }

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
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');
    Config::$isSanitized = true;
    Config::$is3ds = true;

    $selectedItemIds = $request->input('selected_items', []);

    $cartItems = collect(DB::table('carts')
        ->join('products', 'carts.product_id', '=', 'products.id')
        ->whereIn('carts.id', $selectedItemIds)
        ->select('carts.id', 'products.name', 'products.price', 'products.image', 'carts.quantity')
        ->get());

    $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
    $shippingCost = $request->shipping_method === 'express' ? 40000 : 20000;
    $totalAmount = $subtotal + $shippingCost;

    \Log::info('Process checkout request', [
        'selected_items' => $selectedItemIds,
        'subtotal' => $subtotal,
        'shipping_method' => $request->shipping_method,
        'total' => $totalAmount,
        'cart_items' => $cartItems->toArray(),
    ]);

    $params = [
        'transaction_details' => [
            'order_id' => uniqid('ORDER-'),
            'gross_amount' => $totalAmount,
        ],
        'customer_details' => [
            'name' => $request->name,
            'phone' => $request->phone,
            'billing_address' => [
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'region' => $request->region,
                'country' => $request->country,
            ],
        ],
        'item_details' => $cartItems->map(function ($item) {
            return [
                'id' => $item->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->name,
            ];
        })->toArray(),
    ];

    try {
        $snapToken = Snap::getSnapToken($params);
        return response()->json(['snap_token' => $snapToken]);
    } catch (\Exception $e) {
        \Log::error('Midtrans Token Error: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to generate payment token'], 500);
    }
}

}
