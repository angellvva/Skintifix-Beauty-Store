@extends('base.base')

@section('content')
<div class="product-section">
    <div class="container mt-5" style="background-color: white; padding: 30px;">
        <div class="row g-4 align-items-center">
            <!-- Product Image -->
            <div class="col-md-6 text-center">
                <div class="product-image-wrapper shadow-sm rounded" style="background: #ffe8f0; padding: 25px;">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded" style="max-height: 400px; object-fit: contain;">
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <h1 class="fw-bold mb-3" style="color: #e75480;">{{ $product->name }}</h1>

                <h4 class="mb-3" style="color: #d6336c;">
                    Price: <span class="fw-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                </h4>

                <p>
                    <strong>Stock:</strong> 
                    @if($product->stock > 0)
                        <span style="color: #28a745;">{{ $product->stock }} available</span>
                    @else
                        <span style="color: #dc3545;">Out of stock</span>
                    @endif
                </p>

                <hr style="border-color: #f8bbd0;">

                <p class="mb-4" style="color: #6f2a48;">{{ $product->description }}</p>

                <div class="d-flex gap-3">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-pink btn-lg px-4 text-white" style="background-color: #e75480; border:none;">
                            <i class="bi bi-cart3 me-2"></i> Add to Cart
                        </button>
                    </form>

                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-pink btn-lg px-4" style="border-color: #e75480; color: #e75480;">
                            <i class="bi bi-heart me-2"></i> Add to Wishlist
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-image-wrapper {
        background: #ffe8f0;
        padding: 25px;
        border-radius: 12px;
    }

    .btn-pink:hover {
        background-color: #c74370 !important;
    }

    .btn-outline-pink:hover {
        background-color: #e75480 !important;
        color: white !important;
        border-color: #e75480 !important;
    }

    .product-section {
        background-color: #fff0f6;
        padding-top: 1px;
        padding-bottom: 48px;
    }
</style>
@endsection
