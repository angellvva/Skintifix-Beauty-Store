<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
            // Attempt to get the user ID from session or cookies
    $userId = session('id') ?? Cookie::get('id');
    
    if (!$userId) {
        return redirect()->route('login')->with('error', 'You need to be logged in to view your orders.');
    }

    // Fetch orders for the logged-in user
    $orders = Order::where('user_id', $userId)->get();

    // Return the view with the orders data
    return view('order', compact('orders'));
    }

}
