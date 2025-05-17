@extends('base.base')

@section('content')
    <style>
        .product-section {
            background-color: #fff0f6;
        }

        .order-container {
            margin-bottom: 60px;
        }

        .order-card {
            border: 2px solid #e965a7 !important;
            transition: all 0.3s ease;
            width: 260px;
            border-radius: 8px;
        }

        .order-card:hover {
            box-shadow: 0 0 15px rgba(233, 101, 167, 0.5);
            transform: translateY(-5px);
            z-index: 1;
        }

        .order-img {
            height: 160px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .order-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px 10px;
        }

        .empty-order-icon {
            font-size: 60px;
            color: #ccc;
        }

        .empty-order-text {
            font-weight: 500;
            color: #555;
        }

        .empty-order-container {
            padding-top: 100px;
            padding-bottom: 100px;
            text-align: center;
        }

        .btn-checkout {
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

        .btn-checkout i {
            color: #e965a7;
            transition: color 0.3s ease;
        }

        .btn-checkout:hover {
            background-color: #e965a7;
        }

        .btn-checkout:hover i {
            color: white;
        }

        .order-section {
            background-color: #fff0f6;
        }
    </style>
    <div class="product-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">My Orders</h2>

            @if (session('success'))
                <p class="item-desc text-muted mb-4">
                    You have {{ is_countable($orders) ? count($orders) : 0 }}
                    {{ is_countable($orders) && count($orders) === 1 ? 'order' : 'orders' }}
                </p>

                <div id="order-notification" class="alert alert-success"
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
                    <button id="close-order-notification"
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

            @if (isset($orders) && count($orders) > 0)
                <div class="order-container">
                    <div class="order-grid">
                        @foreach ($orders as $order)
                            <div class="card order-card border-0 shadow-sm p-3">
                                <img src="{{ $order->image }}" class="card-img-top order-img mx-auto d-block"
                                    alt="{{ $order->name }}">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $order->name }}</h5>
                                    <p class="card-text text-danger fw-bold">
                                        Rp{{ number_format($order->price, 0, ',', '.') }}
                                    </p>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ url('/customer/order/' . $order->order_id) }}"
                                            class="btn btn-outline-secondary btn-sm">View Order</a>
                                        {{-- <form action="{{ route('cart.add', $order->order_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-checkout" title="Go to checkout">
                                                <i class="fas fa-arrow-right"></i>
                                            </button>
                                        </form> --}}
                                        {{-- <form method="POST" action="{{ route('my-orders') }}"
                                            onsubmit="return confirm('Remove this order from your list?');">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Remove from Orders">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-shopping-bag fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your order is empty.</h4>
                        <p class="text-muted mb-4">Looks like you haven't checkout yet.</p>
                        <a href="{{ route('catalog') }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Checkout Now
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const notification = document.getElementById('order-notification');
            const closeBtn = document.getElementById('close-order-notification');
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
