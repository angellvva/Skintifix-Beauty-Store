<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Halaman dashboard admin
    public function dashboard()
    {
        $totalOrders = DB::table('orders')->count();

        $totalRevenue = DB::table('order_items')
        ->select(DB::raw('SUM(price * quantity) as total'))
        ->value('total');

        $totalProducts = DB::table('products')->count();

        $newCustomers = DB::table('users')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->count();

        $recentOrders = DB::table('orders')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->select(
            'orders.id',
            'users.name as customer',
            'orders.order_date',
            'orders.total_amount',
            'users.name as customer_name',
        )
        ->orderByDesc('orders.order_date','desc')
        ->limit(3)
        ->get();

        $lowStockProducts = DB::table('products')
            ->where('stock', '<=', 3)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'newCustomers',
            'recentOrders',
            'lowStockProducts'
        ));
    }

    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function contacts()
    {
        $messages = DB::table('contacts')->latest()->paginate(10);
        return view('admin.contacts', compact('messages'));
    }
}
