@extends('base.base')

@section('content')
    <div class="product-section">
        <div class="container mt-5">

            <!-- Flash Notification -->
            @if(session('success'))
                <div id="cart-notification" class="alert alert-success"
                    style="
                        position: fixed;
                        top: 110px;
                        right: 205px;
                        background-color: #d4edda;
                        color: #155724;
                        border: 1px solid #c3e6cb;
                        border-radius: 8px;
                        padding: 10px 20px;
                        z-index: 9999;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                        opacity: 1;
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        min-width: 250px;
                    ">
                    <span>{{ session('success') }}</span>
                    <button id="close-notification"
                        style="
                            background: transparent;
                            border: none;
                            color: #155724;
                            font-weight: bold;
                            font-size: 20px;
                            line-height: 1;
                            cursor: pointer;
                            padding: 0 5px;
                            margin-left: 15px;
                        "
                        aria-label="Close notification">&times;</button>
                </div>

                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                        const notification = document.getElementById('cart-notification');
                        const closeBtn = document.getElementById('close-notification');
                        if (!notification) return;

                        const displayTime = 4000;
                        const fadeDuration = 1000;

                        function fadeOutAndHide() {
                            notification.style.transition = `opacity ${fadeDuration}ms ease`;
                            notification.style.opacity = 0;
                            setTimeout(() => {
                                notification.style.display = 'none';
                            }, fadeDuration);
                        }

                        const timeoutId = setTimeout(fadeOutAndHide, displayTime);

                        if (closeBtn) {
                            closeBtn.addEventListener('click', () => {
                                clearTimeout(timeoutId);
                                fadeOutAndHide();
                            });
                        }
                    });
                </script>
            @endif
            
            <!-- Product Info Card -->
            <div class="white-container position-relative mb-5"
                style="background-color: white; padding: 40px 30px 30px 30px; border-radius: 16px;">

                <!-- Back Button -->
                <a href="{{ route('catalog') }}" class="back-btn" title="Back to products">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <div class="row g-4 align-items-center justify-content-center">
                    <!-- Product Image -->
                    <div class="product-image-wrapper mx-auto mt-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded">
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6">
                        @if($isBestSeller)
                                <a href="{{ route('best-seller') }}" 
                                class="badge best-seller-badge ms-2 product-category-label"
                                style="text-decoration: none;">
                                    Best Seller
                                </a>
                            @endif

                            @if($isNewArrival)
                                <a href="{{ route('new-arrival') }}" 
                                class="badge new-arrival-badge ms-2 product-category-label"
                                style="text-decoration: none;">
                                    New Arrival
                                </a>
                            @endif
                        <h1 class="fw-bold mb-3" style="color: #e75480;">
                            {{ $product->name }}
                        </h1>

                        <h4 class="mb-3" style="color: #d6336c;">
                            Price: <span class="fw-semibold">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </h4>

                        <p>
                            <strong>Stock:</strong>
                            @if ($product->stock > 0)
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
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Add to Wishlist"
                                    class="icon-btn-bordered {{ $isInWishlist ? 'btn-wishlist-filled' : 'btn-wishlist-outline' }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Reviews Card -->

            <h2 class="fw-bold mb-4" style="color: #e965a7;">Customer Reviews</h2>
            @if ($product->reviews->count() > 0)
                <div class="p-4"
                    style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
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

                    <div class="text-center mt-4">
                        <a href="{{ route('reviews.create', $product->id) }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Write a Review
                        </a>
                    </div>
                </div>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5"
                        style="background: transparent; border: none; box-shadow: none;">
                        <i class="fas fa-comments fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">No review yet.</h4>
                        <p class="text-muted mb-4">Be the first to write a review!</p>
                        <a href="{{ route('reviews.create', $product->id) }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Write a Review
                        </a>
                    </div>
                </div>
            @endif
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
            font-size: 24px;
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

        .white-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .empty-review-container {
            border: 2px dashed #e965a7;
            border-radius: 16px;
            background-color: #fff0f6;
            max-width: 400px;
            margin: 40px auto 0;
            padding: 40px 20px;
            box-shadow: 0 0 12px rgba(233, 85, 135, 0.15);
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25em 0.6em;
            border-radius: 12px;
            color: white;
            vertical-align: middle;
        }

        .best-seller-badge {
            background-color: #e965a7;
        }

        .new-arrival-badge {
            background-color: transparent;        /* No background */
            border: 2px solid #e965a7;            /* Pink outline */
            color: #e965a7;                       /* Pink text */
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 18px;
            display: inline-block;
        }

        .product-category-label {
            /* background-color: #e965a7;
            color: white; */
            padding: 8px 16px;       /* increase padding for bigger size */
            border-radius: 12px;     /* slightly bigger rounded corners */
            font-weight: 700;        /* make text bolder */
            font-size: 18px;         /* bigger font size */
            display: inline-block;
        }

        .btn-wishlist-filled {
            background-color: #e965a7;
            color: white;
            border-color: #e965a7;
        }

        .btn-wishlist-outline {
            background: none;
            color: #e965a7;
            border: 2px solid #e965a7;
        }
    </style>
@endsection
