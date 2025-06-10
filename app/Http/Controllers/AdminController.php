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
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Query builder untuk kondisi dinamis
        $ordersQuery = DB::table('orders');
        $orderItemsQuery = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id');
        $topSellingQuery = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id');

        if ($startDate && $endDate) {
            $ordersQuery->whereBetween('order_date', [$startDate, $endDate]);
            $orderItemsQuery->whereBetween('orders.order_date', [$startDate, $endDate]);
            $topSellingQuery->whereBetween('orders.order_date', [$startDate, $endDate]);
        }

        $totalOrders = $ordersQuery->count();

        $totalRevenue = $orderItemsQuery
            ->select(DB::raw('SUM(order_items.price * order_items.quantity) as total'))
            ->value('total');

        $totalProducts = DB::table('products')
            ->whereNull('deleted_at')
            ->count();

        $recentOrders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.id', 'orders.order_date', 'orders.total_amount', 'users.name as customer_name')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('orders.order_date', [$startDate, $endDate]);
            })
            ->orderByDesc('orders.order_date')
            ->limit(5)
            ->get();

        $lowStockProducts = DB::table('products')
            ->where('stock', '<', 20)
            ->whereNull('deleted_at')
            ->paginate(3);

        $topSellingProducts = $topSellingQuery
            ->select(
                'products.id',
                'products.name as product_name',
                'products.price as product_price',
                'product_categories.name as category_name',
                'products.stock as product_stock',
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'product_categories.name', 'products.stock')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // Sales Over Time
        $salesData = DB::table('orders')
            ->selectRaw('DATE(order_date) as date, COUNT(*) as orders')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('order_date', [$startDate, $endDate]);
            })
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $salesLabels = [];
        $salesCounts = [];

        if ($startDate && $endDate) {
            $datePeriod = \Carbon\CarbonPeriod::create($startDate, $endDate);
            foreach ($datePeriod as $date) {
                $formatted = $date->format('Y-m-d');
                $salesLabels[] = $formatted;
                $match = $salesData->firstWhere('date', $formatted);
                $salesCounts[] = $match ? $match->orders : 0;
            }
        } else {
            foreach ($salesData as $row) {
                $salesLabels[] = $row->date;
                $salesCounts[] = $row->orders;
            }
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
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
