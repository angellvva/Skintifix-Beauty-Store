<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function show() {
        return view('home',[
            'product_categories'=>ProductCategory::with(['products'])->get()
        ]);
    }

    public function allProducts()
    {
        $products = Product::all(); // Or paginate(12) if needed
        return view('catalog', compact('products'));
    }
}
