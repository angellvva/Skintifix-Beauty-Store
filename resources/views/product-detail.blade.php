@extends('base.base')

@section('content')
<div class="product-section">
    <div class="container mt-5 white-container position-relative" style="background-color: white; padding: 40px 30px 30px 30px; border-radius: 16px;">

        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="back-btn" title="Back to products">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div class="row g-4 align-items-center justify-content-center">
            <!-- Product Image -->
            <div class="product-image-wrapper mx-auto mt-3">
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
            <!-- Review Section -->
            <hr class="my-5" style="border-color: #f8bbd0;">

            <div class="mt-4">
                <h3 class="fw-bold mb-4" style="color: #e75480;">Customer Reviews</h3>

                @if ($product->reviews->count() > 0)
                    @foreach ($product->reviews as $review)
                        <div class="mb-4 p-3 border rounded" style="border-color: #f8bbd0; background-color: #fff7fa;">
                            <strong style="color: #d6336c;">{{ $review->user->name }}</strong>
                            <small class="text-muted"> – {{ $review->created_at->diffForHumans() }}</small>
                            <!-- Star Rating -->
                            <div class="mb-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fas fa-star" style="color: #ffc107;"></i>
                                    @else
                                        <i class="far fa-star" style="color: #ffc107;"></i>
                                    @endif
                                @endfor
                            </div>

                            <!-- Review Content -->
                            <p class="mt-2 mb-0" style="color: #333;">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info text-center" style="border: 1px solid #e965a7; color: #e965a7;">
                        Belum ada review untuk produk ini.
                    </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('reviews.create', $product->id) }}" class="btn rounded-pill px-4 shadow-sm"
                        style="background-color: #e965a7; color: white;">
                        Write a Review
                    </a>
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

    .back-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        background: none;
        border: none;
        border-radius: 12px;
        padding: 10px;
        color: #e965a7;
        font-size: 24px; /* Increased size */
        cursor: pointer;
        transition: color 0.3s ease-in-out;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .back-btn:hover {
        color: #c44c8f;
    }
</style>
@endsection
