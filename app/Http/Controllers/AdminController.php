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

    public function products(Request $request)
    {
        $categoryId = $request->query('category');
        $status = $request->query('status');
        $search = $request->query('search');

        $query = Product::with('category');

        // Filter kategori
        if ($categoryId && $categoryId != 'all') {
            $query->where('category_id', $categoryId);
        }

        // Filter status stok
        if ($status && $status != 'all') {
            if ($status === 'in_stock') {
                $query->where('stock', '>', 20);
            } elseif ($status === 'low_stock') {
                $query->whereBetween('stock', [1, 20]);
            } elseif ($status === 'out_of_stock') {
                $query->where('stock', 0);
            }
        }

        // Filter search nama produk (case insensitive)
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting terbaru
        $query->latest();

        $products = $query->paginate(10)->appends($request->except('page'));

        $categories = ProductCategory::all();

        return view('admin.products', compact('products', 'categories'));
    }


    public function orders()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders', compact('orders'));
    }

    public function customers()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.customers', compact('products'));
    }

    public function categories()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.categories', compact('products'));
    }

    public function inventory()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.inventory', compact('products'));
    }

    public function promotions()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.promotions', compact('products'));
    }

    public function analytics()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.analytics', compact('products'));
    }

    public function messages()
    {
        $messages = DB::table('messages')->latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }
}
