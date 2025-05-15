<?php

namespace App\Http\Controllers; // pastikan namespace ini ada

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = [
            [
                'name' => 'Sensitive Skin Hydration Moisturizer 40ml',
                'price' => 100000,
                'quantity' => 2,
                'image' => 'https://skintific.com/cdn/shop/files/1_8ba35f6c-6216-44df-b8ca-1c361b4ec24a.png?v=1741776053&width=1200',
                'description' => 'Soothes redness in 5 minutes. Design for sensitive skin',
            ],
            [
                'name' => 'Symwhite 377 Dark Spot Serum 20ml',
                'price' => 150000,
                'quantity' => 1,
                'image' => 'https://www.eace.com.my/image/cache/data/SKINTIFIC/ST17-P-480x480.png',
                'description' => 'Enriched SymWhite377 serum with lightweight texture and low',
            ],
        ];

        return view('cart', compact('cartItems'));
    }
}
