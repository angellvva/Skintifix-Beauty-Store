<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Models\Order;
use App\Models\Payments;

class MidtransController extends Controller
{
    //
    public function callback(Request $request)
    {
        $notif = new Notification();

        $orderId = $notif->order_id;
        $status = $notif->transaction_status;
        $type = $notif->payment_type;

        $order = Order::where('invoice_number', $orderId)->first();

        if ($order) {
            $order->status = $status === 'settlement' || $status === 'capture' ? 'paid' : ($status === 'pending' ? 'pending' : 'failed');
            $order->save();

            Payments::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_status' => $order->status,
                    'payment_method' => $type,
                    'payment_date' => now(),
                ]
            );
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
