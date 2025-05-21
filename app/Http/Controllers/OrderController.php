<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    public function index()
    {
        $userId = session('id') ?? Cookie::get('id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your orders.');
        }

        // Ambil semua orders user
        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->get();

        $orderIds = $orders->pluck('id')->toArray();

        // Ambil semua order items yang terkait dengan order ids user tsb, beserta info produk
        $orderItems = DB::table('order_items as oi')
            ->join('products as p', 'oi.product_id', '=', 'p.id')
            ->select(
                'oi.order_id',
                'p.name',
                'p.image',
                'p.price',
                'oi.quantity'
            )
            ->whereIn('oi.order_id', $orderIds)
            ->get();

        // Group order items berdasarkan order_id
        $itemsGrouped = $orderItems->groupBy('order_id');

        $orderCount = $orders->count();

        return view('order', [
            'orders' => $orders,
            'orderItemsGrouped' => $itemsGrouped,
            'orderCount' => $orderCount,
        ]);
    }

    // Show order details and track it
    public function showOrTrack($order_id)
    {
        $order = Order::with('orderItems.product', 'user')->findOrFail($order_id);

        // Loop through the order items and add the estimated delivery and shipping dates
        foreach ($order->orderItems as $orderItem) {
            // Calculate the Estimated Delivery (3 days after order date)
            $orderItem->estimated_delivery = Carbon::parse($order->created_at)->addDays(3)->format('Y-m-d');

            // Calculate the Shipping Date (3 days after Estimated Delivery)
            $orderItem->shipping_date = Carbon::parse($orderItem->estimated_delivery)->addDays(3)->format('Y-m-d');
        }

        // Return the order-detail view with the updated order data
        return view('order-detail', compact('order'));
    }


    // Cancel the order
    public function cancel($order_id)
    {
        // Logic to cancel the order
        $order = Order::findOrFail($order_id);
        $order->status = 'Cancelled'; // Update order status
        $order->save();

        return redirect()->route('order.show', ['order_id' => $order_id])->with('success', 'Order has been cancelled successfully!');
    }
}
