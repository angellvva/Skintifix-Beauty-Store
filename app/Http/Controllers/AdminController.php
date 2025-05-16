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
        $products = Product::latest()->paginate(10);
        return view('admin.orders', compact('products'));
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

        // Sorting berdasarkan status dropdown
        switch ($request->input('status')) {
            case 'highest_spend':
                // Menghitung total spent per user menggunakan withSum
                $query->withSum('orders', 'total_amount')->orderBy('orders_sum_total_amount', 'desc');
                break;

            case 'most_orders':
                $query->withCount('orders')
                    ->withSum('orders', 'total_amount')
                    ->orderBy('orders_count', 'desc')
                    ->orderBy('orders_sum_total_amount', 'desc');
                break;
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.customers', compact('customers'));
    }


    public function categories()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.categories', compact('products'));

        // Filter type
        if ($request->type == 'new') {
            $query->whereDate('created_at', '>=', now()->subMonth());
        } elseif ($request->type == 'repeat') {
            $query->has('orders', '>=', 2);
        }

        // Ambil semua dulu (karena sort 'total_spent' harus dilakukan di memory)
        $customers = $query->get()->map(function ($user) {
            $user->total_spent = $user->orders->sum('total_amount');
            $user->last_order = optional($user->orders->first())->order_date;
            return $user;
        });

        // Sorting logic
        if ($request->sort == 'orders') {
            $customers = $customers->sortByDesc('orders_count');
        } elseif ($request->sort == 'spent') {
            $customers = $customers->sortByDesc('total_spent');
        } else {
            $customers = $customers->sortByDesc('created_at');
        }

        // Manual pagination (karena ini bukan Query Builder)
        $page = $request->get('page', 1);
        $perPage = 10;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $customers->forPage($page, $perPage),
            $customers->count(),
            $perPage,
            $page,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        // Aggregate data
        $totalCustomers = User::count();
        $newCustomers = User::whereDate('created_at', '>=', now()->subMonth())->count();
        $repeatCustomers = round(
            User::has('orders', '>=', 2)->count() / max($totalCustomers, 1) * 100,
            1
        );
        $avgOrderValue = \App\Models\Order::avg('total_amount') ?? 0;

        return view('admin.customers', [
            'customers' => $paginated,
            'totalCustomers' => $totalCustomers,
            'newCustomers' => $newCustomers,
            'repeatCustomers' => $repeatCustomers,
            'avgOrderValue' => $avgOrderValue,
        ]);
    }
}
