<?php

namespace App\Http\Controllers; // pastikan namespace ini ada

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = [
            [
                'name' => 'Produk A',
                'price' => 100000,
                'quantity' => 2,
                'image' => 'produk-a.jpg',
                'description' => 'Deskripsi produk A',
            ],
            [
                'name' => 'Produk B',
                'price' => 150000,
                'quantity' => 1,
                'image' => 'produk-b.jpg',
                'description' => 'Deskripsi produk B',
            ],
        ];

        return view('cart', compact('cartItems'));
    }
}
