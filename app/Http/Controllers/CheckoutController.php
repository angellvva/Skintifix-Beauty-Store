<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        // Bisa tambahkan data atau logika di sini jika perlu, misal data order, user, dll.
        return view('checkout'); // Pastikan file checkout.blade.php ada di resources/views
    }
}
