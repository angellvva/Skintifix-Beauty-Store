<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        // Query for user's orders
        $ordersQuery = DB::table('orders')->where('user_id', $user->id);

        if ($search) {
            if (ctype_digit($search)) {
                $ordersQuery->where('id', 'like', "%{$search}%");
            } else {
                $ordersQuery->whereIn('id', function ($query) use ($search) {
                    $query->select('oi.order_id')
                        ->from('order_items as oi')
                        ->join('products as p', 'oi.product_id', '=', 'p.id')
                        ->where('p.name', 'like', "%{$search}%");
                });
            }
        }

        $orders = $ordersQuery->orderBy('id', 'desc')->get();
        $orderIds = $orders->pluck('id')->toArray();

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

        $itemsGrouped = $orderItems->groupBy('order_id');
        $orderCount = $orders->count();

        return view('order', [
            'orders' => $orders,
            'orderItemsGrouped' => $itemsGrouped,
            'orderCount' => $orderCount,
        ]);
    }

    public function showOrTrack($order_id)
    {
        $user = Auth::user();
        $order = Order::with('orderItems.product', 'user')->findOrFail($order_id);

        // Ensure the order belongs to the logged-in user
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        foreach ($order->orderItems as $orderItem) {
            $orderItem->estimated_delivery = Carbon::parse($order->created_at)->addDays(3)->format('Y-m-d');
            $orderItem->shipping_date = Carbon::parse($orderItem->estimated_delivery)->addDays(3)->format('Y-m-d');
        }

        return view('order-detail', compact('order'));
    }

    public function cancel($order_id)
    {
        $user = Auth::user();
        $order = Order::findOrFail($order_id);

        // Ensure the order belongs to the logged-in user
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $order->status = 'Cancelled';
        $order->save();

        return redirect()->route('order.show', ['order_id' => $order_id])
            ->with('success', 'Order has been cancelled successfully!');
    }
}