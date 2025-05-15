<!-- resources/views/checkout.blade.php -->
@extends('base.base')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4" style="color: #e965a7;">Halaman Checkout</h2>

        <!-- Form atau elemen lain untuk checkout -->
        <p>Ini halaman checkout. Isi dengan form pembayaran atau lainnya sesuai kebutuhan.</p>
        
        <form method="POST" action="{{ route('checkout') }}">
            @csrf
            <!-- Form input checkout seperti alamat, metode pembayaran, dll -->
            <button type="submit" class="btn btn-primary">Proses Pembayaran</button>
        </form>
    </div>
@endsection
