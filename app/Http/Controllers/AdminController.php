<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Halaman dashboard admin
    public function dashboard(Request $request)
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
            ->limit(5)
            ->get();

        $lowStockProducts = DB::table('products')
            ->where('stock', '<', 20)
            ->whereNull('deleted_at')
            ->paginate(3);

        $topSellingProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->select(
                'products.id',
                'products.name as product_name',
                'products.price as product_price',
                'product_categories.name as category_name',
                'products.stock as product_stock',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
            )
            ->groupBy('products.id', 'products.name', 'product_categories.name')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();
        
    // Sales Over Time Chart with optional date range filter
        $startDate = $request->input('start_date', now()->subDays(6)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $salesData = DB::table('orders')
            ->selectRaw('DATE(order_date) as date, COUNT(*) as orders')
            ->whereBetween('order_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesLabels = [];
        $salesCounts = [];

        $datePeriod = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($datePeriod as $date) {
            $formatted = $date->format('Y-m-d');
            $salesLabels[] = $formatted;
            $match = $salesData->firstWhere('date', $formatted);
            $salesCounts[] = $match ? $match->orders : 0;
        }


        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'newCustomers',
            'recentOrders',
            'lowStockProducts',
            'topSellingProducts',
            'salesLabels', 
            'salesCounts',
            'startDate',
            'endDate'
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

        // Filter search berdasarkan nama
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%");
        }

        $messages = $query->latest()->get();
        $totalMessages = DB::table('messages')->count();

        return view('admin.messages', compact('messages', 'totalMessages'));
    }
}
