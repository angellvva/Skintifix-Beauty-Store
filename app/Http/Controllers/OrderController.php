<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class OrderController extends Controller
{
    // Show orders for the logged-in user
    public function index()
    {
        // Attempt to get the user ID from session or cookies
        $userId = session('id') ?? Cookie::get('id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your orders.');
        }
        // Fetch orders for the logged-in user
        $orders = DB::table('orders')
            ->where('user_id', $userId)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.id as order_id', 'products.name', 'products.price', 'products.image', 'orders.created_at', 'orders.status', 'orders.total_amount')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Return the orders view with the orders data
        return view('order', compact('orders'));
    }

    // Show a single order details
    public function showOrder($orderId)
    {
        // Attempt to get the user ID from session or cookies
        $userId = session('id') ?? Cookie::get('id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view order details.');
        }

        // Fetch order details for the logged-in user
        $order = DB::table('orders')
            ->where('user_id', $userId)
            ->where('orders.id', $orderId)
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.id as order_id', 'products.name', 'products.price', 'products.image', 'orders.created_at', 'orders.status', 'orders.total_amount')
            ->first();

        if (!$order) {
            return redirect()->route('my-orders')->with('error', 'Order not found.');
        }

        // Return the order detail view with the order data
        return view('order-detail', compact('order'));
    }

    // Cancel the order (soft delete or remove from user's order history)
    public function cancelOrder($orderId)
    {
        // Attempt to get the user ID from session or cookies
        $userId = session('id') ?? Cookie::get('id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to cancel your order.');
        }

        // Check if the order belongs to the logged-in user
        $order = DB::table('orders')->where('user_id', $userId)->where('id', $orderId)->first();

        if (!$order) {
            return redirect()->route('my-orders')->with('error', 'Order not found.');
        }

        // Proceed with canceling the order (updating its status or deleting it from the user's order history)
        DB::table('orders')->where('id', $orderId)->update(['status' => 'canceled']); // Example of updating order status

        return redirect()->route('my-orders')->with('success', 'Your order has been canceled.');
    }

    // Create a new order (after checkout process)
    public function createOrder(Request $request)
    {
        // Attempt to get the user ID from session or cookies
        $userId = session('id') ?? Cookie::get('id');
        
        if (!$userId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to place an order.');
        }

        // Validate the request (e.g., ensure required fields like product_id, quantity, etc. are provided)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_amount' => 'required|numeric',
        ]);

        // Create the order
        DB::table('orders')->insert([
            'user_id' => $userId,
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity'),
            'total_amount' => $request->input('total_amount'),
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('my-orders')->with('success', 'Your order has been placed.');
    }
}
