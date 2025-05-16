@extends('base.base')

@section('content')
<div class="product-section">
    <div class="container mt-5 white-container position-relative" style="background-color: white; padding: 30px; border-radius: 16px;">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" 
       class="icon-btn-bordered back-btn" 
       title="Back to products">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="row g-4 align-items-center justify-content-center">
        <!-- Product Image -->
        <div class="product-image-wrapper mx-auto">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded">
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

                <div class="d-flex align-items-center gap-3">
                    <!-- Add to Cart -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Add to Cart" class="icon-btn-bordered">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    </form>

                    <!-- Add to Wishlist -->
                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" title="Add to Wishlist" class="icon-btn-bordered">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-section {
        background-color: #fff0f6;
        padding: 50px 0;
    }

    .product-image-wrapper {
        border: 2px solid #e965a7;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        background-color: #fff;
        max-width: 400px;
        margin: auto;
    }

    .icon-btn-bordered {
        background: none;
        border: 2px solid #e965a7;
        border-radius: 12px;
        padding: 10px 16px;
        color: #e965a7;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .icon-btn-bordered:hover {
        background-color: #e965a7;
        color: white;
        border-color: #e965a7;
    }
</style>
@endsection
