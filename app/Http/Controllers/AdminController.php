<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
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
                'users.name as customer_name'
            )
            ->orderByDesc('orders.order_date', 'desc')
            ->limit(3)
            ->get();

        $lowStockProducts = DB::table('products')
            ->where('stock', '<=', 10)
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

    public function customers(Request $request)
    {
        $query = User::with('orders')
            ->where('name', '!=', 'admin')
            ->whereHas('orders');

        // Filter search berdasarkan nama
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Ambil status dengan default 'highest_spend'
        $status = $request->input('status', 'highest_spend');

        switch ($status) {
            case 'highest_spend':
                // Total belanja tertinggi
                $query->withSum('orders', 'total_amount')
                    ->orderBy('orders_sum_total_amount', 'desc');
                break;

            case 'most_orders':
                // Jumlah pesanan terbanyak
                $query->withCount('orders')
                    ->withSum('orders', 'total_amount')
                    ->orderBy('orders_count', 'desc')
                    ->orderBy('orders_sum_total_amount', 'desc');
                break;
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers', compact('customers'));
    }

    public function messages(Request $request)
    {
        $query = DB::table('messages');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('message', 'like', "%$search%");
        }

        $messages = $query->latest()->get();
        $totalMessages = DB::table('messages')->count();

        return view('admin.messages', compact('messages', 'totalMessages'));
    }
}
