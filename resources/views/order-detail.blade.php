@extends('base.base')

@section('content')
    <style>
        .order-detail-section {
            background-color: #f9f9f9;
            padding: 40px 0;
        }

        .order-detail-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .order-header h2 {
            color: #333;
            font-size: 32px;
            font-weight: bold;
        }

        .order-header .order-id {
            font-size: 18px;
            color: #777;
        }

        .order-product {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
        }

        .order-product img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }

        .order-product-details {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .order-product-details p {
            font-size: 18px;
            color: #555;
        }

        .order-status {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: orange;
        }

        .order-actions {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .order-actions .track-btn,
        .order-actions .cancel-btn {
            padding: 12px 20px;
            background-color: #e965a7;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
        }

        .order-actions .cancel-btn {
            background-color: #ff6b6b;
        }

        .order-actions .track-btn:hover,
        .order-actions .cancel-btn:hover {
            background-color: #d84f91;
        }

        .order-total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }
    </style>

    <div class="order-detail-section">
        <div class="order-detail-container">
            <div class="order-header">
                <h2>My Order</h2>
                <p class="order-id">Order ID: #{{ $order->order_id }}</p>
            </div>

            <div class="order-product">
                <div class="order-product-header">
                    <img src="{{ $order->product_image }}" alt="{{ $order->product_name }}">
                    <div>
                        <h3>{{ $order->product_name }}</h3>
                        <p>By: {{ $order->seller_name }}</p>
                    </div>
                </div>

                <div class="order-product-details">
                    <p><strong>Size:</strong> {{ $order->size }}</p>
                    <p><strong>Qty:</strong> {{ $order->quantity }}</p>
                    <p><strong>Price:</strong> ₹{{ number_format($order->price, 0, ',', '.') }}</p>
                </div>

                <div class="order-status">
                    Status: {{ $order->status }} <br> 
                    Delivery Expected by: {{ \Carbon\Carbon::parse($order->delivery_expected)->format('d F Y') }}
                </div>
            </div>

            <div class="order-actions">
                <a href="{{ route('order.show', ['order_id' => $order->order_id]) }}" class="track-btn">Track Order</a>
                <a href="{{ route('order.cancel', ['order_id' => $order->order_id]) }}" class="cancel-btn">Cancel Order</a>
            </div>

            <div class="order-total">
                Total: {{ number_format($order->total_price, 0, ',', '.') }}
            </div>
        </div>
    </div>
@endsection
