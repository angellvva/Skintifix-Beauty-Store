<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        ->where('orders.user_id', $userId)  // Explicitly specify the table for user_id
        ->join('products', 'orders.product_id', '=', 'products.id')
        ->leftJoin('reviews', 'orders.id', '=', 'reviews.id')  // Ensure 'reviews.order_id' exists
        ->select(
            'orders.id as order_id',
            'products.name',
            'products.price',
            'products.image',
            'orders.created_at',
            'orders.status',
            'orders.total_amount',
            'orders.estimated_delivery',
            'reviews.rating'
        )
        ->orderBy('orders.created_at', 'desc')
        ->get();

        // Loop through the orders to calculate estimated delivery and shipping dates
        foreach ($orders as $order) {
            // Calculate Estimated Delivery (3 days after order date)
            $order->estimated_delivery = Carbon::parse($order->created_at)->addDays(3)->format('Y-m-d');
            // Calculate Shipping Date (3 days after Estimated Delivery)
            $order->shipping_date = Carbon::parse($order->estimated_delivery)->addDays(3)->format('Y-m-d');
        }

        // Return the orders view with the orders data
        return view('order', compact('orders'));
    }

    // Other methods (showOrder, cancelOrder, createOrder) remain unchanged
}