<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\OrderDetail;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
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

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        $userId = Auth::id();
        $user = DB::table('users')->where('id', $userId)->first();

        return view('checkout', compact('cartItems', 'subtotal', 'user'));
    }

    public function process(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');  // Pastikan client_key sudah ada di .env atau config
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $selectedItemIds = $request->input('selected_items', []);

        $cartItems = collect(DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->whereIn('carts.id', $selectedItemIds)
            ->select('carts.id as cart_id', 'products.name', 'products.price', 'products.image', 'carts.quantity')
            ->get());

        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        $shippingCost = $request->shipping_method === 'express' ? 40000 : 20000;
        $totalAmount = $subtotal + $shippingCost;

        // Log info
        Log::info('Process checkout request', [
            'selected_items' => $selectedItemIds,
            'subtotal' => $subtotal,
            'shipping_method' => $request->shipping_method,
            'total' => $totalAmount,
            'cart_items' => $cartItems->toArray(),
        ]);

        DB::beginTransaction();
        try {
            $recipient_name = $request->input('recipient_name', 'default recipient'); // default value jika tidak ada input
            $recipient_phone = $request->input('recipient_phone', Auth::user()->phone);  // Ganti default_phone_number jika tidak ada input

            $order = Order::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id' => Auth::id(),
                'recipient_name' => $recipient_name,
                'recipient_phone' => $recipient_phone,
                'total_price' => $totalAmount,
                'status' => 'pending',
                'payment_url' => null,  // URL pembayaran akan diset setelah transaksi Midtrans selesai
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->cart_id,
                    'product_name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->invoice_number,
                    'gross_amount' => $totalAmount,
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'last_name' => '',
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'billing_address' => [
                        'address' => $request->address,
                        'postal_code' => $request->postal_code,
                        'region' => $request->region,
                        'country' => $request->country,
                    ],
                ],
                'item_details' => $cartItems->map(function ($item) {
                    return [
                        'id' => $item->cart_id,
                        'price' => $item->price,
                        'quantity' => $item->quantity,
                        'name' => $item->name,
                    ];
                })->toArray(),
            ];

            $snapUrl = Snap::createTransaction($params)->redirect_url;

            $order->payment_url = $snapUrl;
            $order->save();

            DB::commit();

            session()->forget('cart');

            return redirect($snapUrl);

        } catch (\Exception $e) {
            // Rollback jika terjadi error
            DB::rollBack();
            Log::error('Midtrans Token Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
