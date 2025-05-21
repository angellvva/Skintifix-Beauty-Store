@extends('base.base')

@section('content')
    <style>
        .order-section {
            background-color: #fff0f6;
        }

        .order-card {
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: white;
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .order-left {
            flex: 2;
            padding-right: 30px;
        }

        .order-left p,
        .order-left h5 {
            margin: 10px 0;
            font-size: 20px;
        }

        .order-right {
            flex: 1;
            text-align: center;
            position: relative;
        }

        .order-img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 10px;
        }

        .btn-view-order {
            display: block;
            background-color: #e965a7;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            margin-top: 10px;
            width: 100%;
            text-align: center;
        }

        .btn-view-order:hover {
            background-color: #d84f91;
        }
    </style>

    <div class="order-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">My Order</h2>
            @if (session('success'))
                <div id="order-notification" class="alert alert-success">
                    <span>{{ session('success') }}</span>
                    <button id="close-order-notification"
                        style="background: transparent; border: none; color: #155724; font-weight: bold; font-size: 20px; line-height: 1; cursor: pointer; padding: 0 5px; margin-left: 15px;"
                        aria-label="Close notification">&times;</button>
                </div>
            @endif

            @if (isset($orders) && count($orders) > 0)
                <div class="order-grid">
                    @foreach ($orders as $order)
                        <div class="order-card">
                            <div class="order-left">
                                <p class="fw-bold">SKINTIFIX-{{ str_pad($order->order_id, 5, '0', STR_PAD_LEFT) }}</p>
                                <h5>{{ $order->name }}</h5>
                                <br>
                                <p><strong>Price:</strong> Rp{{ number_format($order->price, 0, ',', '.') }}</p>
                                <p><strong>Order Date:</strong>
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                                <p><strong>Estimated Delivery:</strong> {{ $order->estimated_delivery }}</p>
                                <p><strong>Shipping Date:</strong> {{ $order->shipping_date }}</p>

                            </div>
                            <div class="order-right">
                                <img src="{{ $order->image }}" alt="{{ $order->name }}" class="order-img">
                                <a href="{{ route('order.show', ['order_id' => $order->order_id]) }}"
                                    class="btn-view-order">Order Detail</a>
                            </div>
                    @endforeach
                </div>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-shopping-bag fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your order is empty.</h4>
                        <p class="text-muted mb-4">Looks like you haven't checked out yet.</p>
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

            const displayTime = 4000; // duration before auto fade
            const fadeDuration = 1000; // fade-out duration

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
