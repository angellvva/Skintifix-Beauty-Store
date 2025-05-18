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

        .order-product-list {
            margin-top: 20px;
        }

        .order-product-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .order-product-item img {
            width: 100px;
            height: 100px;
        }

        .order-product-item-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        .order-product-item-details p {
            margin: 5px 0;
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

        .order-actions .cancel-btn {
            padding: 12px 20px;
            background-color: #ff6b6b;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
        }

        .order-actions .cancel-btn:hover {
            background-color: #d84f91;
        }

        .order-total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }

        .order-address {
            margin-top: 20px;
            font-size: 18px;
            color: #555;
        }
    </style>

    <div class="order-detail-section">
        <div class="order-detail-container">
            <div class="order-header">
                <h2>My Order</h2>
                <p class="order-id">Order ID: #{{ $order->id }}</p>
            </div>

            <div class="order-product-list">
                @foreach ($order->items as $item)
                    <div class="order-product-item">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                        <div class="order-product-item-details">
                            <h3>{{ $item->product->name }}</h3>
                            <p><strong>Qty:</strong> {{ $item->quantity }}</p>
                            <p><strong>Price:</strong> Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="order-status">
                Status: {{ $order->status }} <br>
                Delivery Expected by: {{ \Carbon\Carbon::parse($order->estimated_delivery)->format('d F Y') }} <br>
                Shipping Date: {{ \Carbon\Carbon::parse($order->shipping_date)->format('d F Y') }}
            </div>

            <div class="order-total">
                Total: Rp{{ number_format($order->total_amount, 0, ',', '.') }}
            </div>

            <div class="order-address">
                <h3>Shipping Address:</h3>
                <p>{{ $order->user->address }}</p>
            </div>

            <div class="order-actions">
                <a href="{{ route('order.cancel', ['order_id' => $order->id]) }}" class="cancel-btn">Cancel Order</a>
            </div>
        </div>
    </div>
@endsection
