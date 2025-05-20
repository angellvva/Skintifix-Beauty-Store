@extends('base.base')

@section('content')
<style>
    .card {
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

    .order-detail-section {
        background-color: #fff0f6;
        padding: 60px 0;
    }

    .order-detail-container {
        background-color: white;
        border-radius: 16px;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .order-header h2 {
        font-size: 32px;
        font-weight: bold;
    }

    .order-header .order-id {
        font-size: 18px;
        color: #777;
    }

    .order-product-list {
        margin-top: 20px;
    }

    .order-product-item {
        display: flex;
        justify-content: flex-start;
        margin-bottom: 15px;
        padding-bottom: 10px;
        position: relative;
    }

    .order-product-item img {
        width: 200px;
        height: 200px;
        object-fit: contain;
        border-radius: 12px;
        margin-right: 20px; /* Increased margin between image and text */
    }

    .order-product-item-details {
        flex-grow: 1;
    }

    .order-product-item-details p {
        margin: 5px 0;
    }

    /* Extended line under product item */
    .order-product-item::after {
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background-color: #ddd;
        position: absolute;
        bottom: 0;
        left: 0;
    }

    .order-status {
        margin-top: 20px;
        font-size: 18px;
        font-weight: bold;
        color: black;
    }

    .order-status p {
        font-weight: normal;
    }

    .order-actions {
        margin-top: 30px;
        display: flex;
        justify-content: space-between;
    }

    /* Right-aligned Total (above the line) */
    .order-total {
        font-size: 20px;
        font-weight: bold;
        margin-top: 20px;
        text-align: right; /* Align total to the right */
        position: relative;
        z-index: 2; /* Ensure total is above the line */
    }

    .order-address {
        margin-top: 20px;
        font-size: 18px;
        color: black;
    }
</style>

<div class="order-detail-section">
    <div class="container">
        <h2 class="fw-bold mb-4" style="color: #e965a7;">My Order</h2>
        <div class="card">
            <div class="card-body">
                <div class="order-product-list">
                    @foreach ($order->orderItems as $orderItem)
                        <div class="order-product-item">
                            <img src="{{ $orderItem->product->image }}" alt="{{ $orderItem->product->name }}">
                               <div class="order-product-item-details">
                                    <p class="order-id" style="color:black;">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    <h3>{{ $orderItem->product->name }}</h3>
                                    <p><strong>Qty:</strong> {{ $orderItem->quantity }}</p>
                                    <p><strong>Price:</strong> Rp{{ number_format($orderItem->price, 0, ',', '.') }}</p>
                                    <div class="mb-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star" style="color: {{ $i <= $orderItem->rating ? '#ffc107' : '#ddd' }};"></i>
                                        @endfor
                                    </div>
                                </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Right-aligned (above the line) -->
                <div class="order-total">
                    Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                </div>

                <div class="order-status">
                    <p><strong>Status:</strong> {{ $order->status }} </p>
                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                    <p><strong>Estimated Delivery:</strong> {{ \Carbon\Carbon::parse($orderItem->estimated_delivery)->format('d M Y') }}</p>
                    <p><strong>Shipping Date:</strong> {{ \Carbon\Carbon::parse($orderItem->shipping_date)->format('d M Y') }}</p>
                </div>

                <div class="order-address">
                    <h3>Address:</h3>
                    <p>{{ $order->user->address }}</p>
                </div>
            </div>       
        </div>
    </div>
@endsection
