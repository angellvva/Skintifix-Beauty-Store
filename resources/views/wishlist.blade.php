@extends('base.base')

@section('content')
    <style>
        .product-section {
            background-color: #fff0f6;
        }

        .product-section h2 {
            color: #e965a7;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }

        .item-desc {
            margin-bottom: 30px;
        }

        .wishlist-card {
            background-color: #fff;
            border-radius: 12px;
            width: calc(25% - 24px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            text-align: center;
            overflow: hidden;
        }

        .wishlist-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
        }

        .wishlist-img {
            height: 160px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .wishlist-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 24px;
            justify-content: center;
        }

        .empty-wishlist-icon {
            font-size: 60px;
            color: #ccc;
        }

        .empty-wishlist-text {
            font-weight: 500;
            color: #555;
        }

        .empty-wishlist-container {
            padding-top: 100px;
            padding-bottom: 100px;
            text-align: center;
        }

        .btn-cart-pink {
            border: 1px solid #e965a7;
            border-radius: 8px;
            background: none;
            width: 33px;
            height: 31px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-cart-pink i {
            color: #e965a7;
            transition: color 0.3s ease;
        }

        .btn-cart-pink:hover {
            background-color: #e965a7;
        }

        .btn-cart-pink:hover i {
            color: white;
        }

        .btn-outline-pink {
            border: 1px solid #e965a7;
            color: #e965a7;
            background-color: white;
        }

        .btn-outline-pink:hover {
            background-color: #e965a7;
            color: white;
        }

        .product-out-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: inherit;
            z-index: 30;
            pointer-events: none;
        }

        .product-out-label {
            background-color: #e965a7;
            color: white;
            font-weight: bold;
            font-size: 16px;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .product-name {
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;

            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .wishlist-card {
                width: 100%;
                max-width: 100%;
            }

            .wishlist-grid {
                flex-direction: column;
                gap: 16px;
                padding: 0 12px;
            }

            .product-name {
                font-size: 16px;
            }

            .wishlist-img {
                height: 140px;
            }

            .btn-cart-pink,
            .btn-outline-pink,
            .btn.btn-outline-danger {
                width: 36px;
                height: 36px;
            }

            .card-body {
                padding: 10px;
            }

            .btn-cart-pink i,
            .btn-outline-pink i {
                font-size: 16px;
            }
        }
    </style>
    <div class="product-section">
        <div class="container py-5">
            <h2>My Wishlist</h2>

            @if (session('success'))
                <div id="cart-notification" class="alert alert-success"
                    style="
                        position: fixed;
                        top: 90px;
                        right: 10px;
                        background-color: #d4edda;  /* hijau muda */
                        color: #155724;             /* hijau gelap */
                        border: 1px solid #c3e6cb; /* border hijau */
                        border-radius: 8px;
                        padding: 10px 20px 10px 15px;
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
            @endif

            @if (isset($wishlistProducts) && count($wishlistProducts) > 0)
                <div class="wishlist-grid">
                    @foreach ($wishlistProducts as $item)
                        <div class="card wishlist-card border-0 shadow-sm p-3 position-relative">
                            <a href="{{ route('product.detail', $item->id) }}"
                                style="text-decoration: none; color: inherit;">
                                @if ($item->stock == 0)
                                    <div class="product-out-overlay">
                                        <div class="product-out-label">Out of Stock</div>
                                    </div>
                                @endif

                                <img src="{{ $item->image }}" class="card-img-top wishlist-img mx-auto d-block"
                                    alt="{{ $item->name }}">

                                <div class="card-body text-center">
                                    <h5 class="product-name">{{ $item->name }}</h5>
                                    <p class="fw-bold" style="color: #e965a7;">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted d-block mb-2">Stock: {{ $item->stock }}</small>
                                    <div class="d-flex justify-content-center gap-2 position-relative" style="z-index: 40;">
                                        @if ($item->stock > 0)
                                            <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn-cart-pink" title="Add to cart">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('wishlist.remove') }}"
                                            onsubmit="return confirm('Remove this item from your wishlist?');">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Remove from Wishlist">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-heart fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your wishlist is empty.</h4>
                        <p class="text-muted mb-4">Save your favorite items here for later.</p>
                        <a href="{{ route('catalog') }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const notification = document.getElementById('cart-notification');
            const closeBtn = document.getElementById('close-notification');
            if (!notification) return;

            const displayTime = 4000; // durasi tampil notifikasi sebelum auto fade
            const fadeDuration = 1000; // durasi animasi fade out

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
@endsection
