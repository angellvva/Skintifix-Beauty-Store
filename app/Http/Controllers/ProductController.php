<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function detail($id)
    {
        // Ambil data produk berdasarkan ID, jika tidak ditemukan akan 404
        $product = Product::findOrFail($id);

        // Kirim data produk ke view product-detail.blade.php
        return view('product-detail', compact('product'));
    }
}
