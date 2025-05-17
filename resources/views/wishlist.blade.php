@extends('base.base')

@section('content')
    <style>
        .product-section {
            background-color: #fff0f6;
        }

        .item-desc {
            margin-bottom: 30px;
        }

        .wishlist-container {
            margin-bottom: 60px;
        }

        .wishlist-card {
            border: 2px solid #e965a7 !important;
            transition: all 0.3s ease;
            width: 260px;
            border-radius: 8px;
        }

        .wishlist-card:hover {
            box-shadow: 0 0 15px rgba(233, 101, 167, 0.5);
            transform: translateY(-5px);
            z-index: 1;
        }

        .wishlist-img {
            height: 160px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .wishlist-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px 10px;
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
    </style>
    <div class="product-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">My Wishlist</h2>

            @if (session('success'))
                <p class="item-desc text-muted mb-4">
                    You have {{ is_countable($wishlistProducts) ? count($wishlistProducts) : 0 }}
                    {{ is_countable($wishlistProducts) && count($wishlistProducts) === 1 ? 'item' : 'items' }}
                </p>

                <div id="cart-notification" class="alert alert-success"
                    style="
                        position: fixed;
                        top: 120px;
                        right: 313px;
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
                <div class="wishlist-container">
                    <div class="wishlist-grid">
                        @foreach ($wishlistProducts as $item)
                            <div class="card wishlist-card border-0 shadow-sm p-3">
                                <img src="{{ $item->image }}" class="card-img-top wishlist-img mx-auto d-block"
                                    alt="{{ $item->name }}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text text-danger fw-bold">
                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('product.detail', $item->id) }}"
                                            class="btn btn-sm btn-outline-pink" title="View Product Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-cart-pink" title="Add to cart">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                        </form>
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
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-heart fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your wishlist is empty.</h4>
                        <p class="text-muted mb-4">Save your favorite items here for later...</p>
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