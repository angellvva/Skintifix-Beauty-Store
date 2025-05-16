<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class AdminProductController extends Controller
{
    //
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

    public function add_product()
    {
        //
        return view('admin.add-product');
    }
}
