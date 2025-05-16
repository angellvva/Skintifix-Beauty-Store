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
}
