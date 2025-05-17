<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    public function index()
    {
        $orders = Order::with('user', 'orderItems')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('user', 'orderItems')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Shipped,Delivered,Cancelled,Completed',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->route('admin.orders')->with('success', 'Order updated successfully.');
    }

    public function orders(Request $request)
    {
        $query = Order::with('user', 'orderItems');

        if ($request->filled('search')) {
            $orderId = $request->input('search');

            if (is_numeric($orderId)) {
                $query->where('id', $orderId);
            } else {
                $query->whereRaw('0 = 1');
            }
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Validasi sort hanya boleh 'asc' atau 'desc'
        $sort = $request->input('sort', 'desc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $orders = $query->orderBy('order_date', $sort)->paginate(5);

        return view('admin.orders', compact('orders'));
    }
}
