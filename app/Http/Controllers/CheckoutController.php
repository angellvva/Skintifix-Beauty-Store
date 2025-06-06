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
use App\Models\OrderItem;
use App\Models\Payments;
use Midtrans\Transaction;


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
            return redirect()->route('cart.view')->with('error', 'Please select at least one product to checkout.');
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
            ->select('carts.id as cart_id', 'products.id as product_id', 'products.name', 'products.price', 'products.image', 'carts.quantity')
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
            $recipient_name = $request->input('name'); // default value jika tidak ada input
            $recipient_phone = $request->input('recipient_phone', Auth::user()->phone);  // Ganti default_phone_number jika tidak ada input
            $recipient_address = $request->input('address');
            // dd($recipient_phone);
            $order = Order::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'user_id' => Auth::id(),
                'recipient_name' => $recipient_name,
                'recipient_phone' => $recipient_phone,
                'recipient_address' => $recipient_address,
                'subtotal' => $subtotal,
                'shipping_price' => $shippingCost,
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_url' => null,  // URL pembayaran akan diset setelah transaksi Midtrans selesai
            ]);
            // dd($order);
            Log::info('Order created with invoice_number: ' . $order->invoice_number); // Log untuk memastikan invoice_number terisi


            Payments::create([
                'order_id' => $order->id,
                'payment_status' => 'pending',
                'payment_method' => null, // akan diupdate oleh Midtrans callback
                'payment_date' => null,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);

                // ngurangi stok produk di db
                DB::table('products')
                    ->where('id', $item->product_id)
                    ->decrement('stock', $item->quantity);

                // hapus produk dari cart
                DB::table('carts')->whereIn('id', $selectedItemIds)->delete();

            }

            Log::info('Generated order ID:', ['invoice' => $order->invoice_number]);

            $params = [
            'transaction_details' => [
                'order_id' => $order->invoice_number,
                'gross_amount' => (int) $totalAmount,
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
            'item_details' => array_merge(
                $cartItems->map(function ($item) {
                    return [
                        'id' => $item->cart_id,
                        'price' => (int) $item->price,
                        'quantity' => (int) $item->quantity,
                        'name' => $item->name,
                    ];
                })->toArray(),
                [[
                    'id' => 'SHIPPING',
                    'price' => (int) $shippingCost,
                    'quantity' => 1,
                    'name' => 'Shipping Cost'
                ]]
            ),
            'callbacks'=> [
                'finish'=>route('payment.success'),
            ],
        ];

        Log::info('Sending transaction to Midtrans with order_id: ' . $order->invoice_number); // Log untuk memastikan order_id yang dikirim ke Midtrans

            $snapUrl = Snap::createTransaction($params)->redirect_url;

            $order->payment_url = $snapUrl;
            $order->save();

            // Log::info()

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

    public function paymentSuccess(Request $request)
{
    $orderId = $request->get('order_id'); // Dapatkan order_id dari URL
    $order = Order::where('invoice_number', $orderId)->first(); // Cek apakah order ada

    if (!$order) {
        return redirect()->route('catalog')->with('error', 'Order not found.'); // Kalau order tidak ditemukan
    }

    // Konfigurasi Midtrans
    Config::$serverKey = config('midtrans.server_key');
    Config::$isProduction = config('midtrans.is_production');

    try {
        $status = Transaction::status($order->invoice_number); // Mengecek status transaksi di Midtrans

        // Update status order berdasarkan response dari Midtrans
        if ($status->transaction_status === 'settlement' || $status->transaction_status === 'capture') {
            $order->status = 'paid';
        } elseif ($status->transaction_status === 'pending') {
            $order->status = 'pending';
        } elseif ($status->transaction_status === 'expire') {
            $order->status = 'expired';
        } elseif ($status->transaction_status === 'cancel') {
            $order->status = 'cancelled';
        } else {
            $order->status = $status->transaction_status;
        }

        $order->save(); // Simpan perubahan status ke database
        $payment = Payments::where('order_id', $order->id)->first();
        if ($payment) {
            $payment->payment_status = $status->transaction_status;  // Update payment_status
            $payment->payment_date = now();  // Set payment_date
            $payment->payment_method = $status->payment_type; // Bisa menambahkan payment_type di sini sesuai dengan data dari Midtrans
            $payment->save();  // Simpan perubahan status di tabel payments
        }
                Log::info('Midtrans Response:', ['status' => $status]);




    } catch (\Exception $e) {
        \Log::error('Failed to check payment status: ' . $e->getMessage()); // Jika gagal memeriksa status Midtrans
    }

    // Mengarahkan ke halaman payment-success dan mengirimkan data order ke view
    return view('payment-success', [
        'order' => $order, // Mengirim data order
        'status_message' => 'Payment status updated.'
    ]);
}

}
