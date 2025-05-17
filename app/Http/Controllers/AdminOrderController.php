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
        $order = Order::with('user', 'orderItems','payment')->findOrFail($id);
        return view('admin.orders-show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::with('user', 'orderItems','payment')->findOrFail($id);
        return view('admin.orders-edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed',
        ]);

        $request->validate([
            'status' => 'required|in:pending,processing,completed',
            'payment_status' => 'nullable|in:paid,failed',
        ]);

        $order = Order::with('payment')->findOrFail($id);
        $order->status = $request->status;

        // Simpan status pembayaran
        if ($order->payment) {
            $order->payment->payment_status = $request->payment_status;
            $order->payment->save();
        }

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
        $totalOrders = Order::count();
        $totalPending = Order::where('status', 'pending')->count();
        $totalProcessing = Order::where('status', 'processing')->count();
        $totalCompleted = Order::where('status', 'completed')->count();

        $orders = $query->orderBy('order_date', $sort)->paginate(10);

        return view('admin.orders', compact(
        'orders',
        'totalOrders',
        'totalPending',
        'totalProcessing',
        'totalCompleted'
        ));
    }
}
