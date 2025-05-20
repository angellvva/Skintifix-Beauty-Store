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
        $categories = ProductCategory::all();
        return view('admin.add-product', compact('categories'));
    }

    public function delete_product(Request $request)
    {
        $productID = $request->input('product_id');

        if ($productID) {
            Product::destroy($productID);
            return redirect()->back()->with('success', 'Product deleted successfully.');
        }

        return redirect()->back()->with('error', 'Product not found.');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'image'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ]);

        // Simpan gambar ke storage
        $imagePath = $request->file('image')->store('products', 'public');

        // Simpan ke database
        Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'image'       => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        return view('admin.product-edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }
}
