<!-- resources/views/myorders.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .order-box {
            border: 2px solid #e965a7;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background-color: #fff;
            max-width: 500px;
            margin-top: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-box h2 {
            color: #e965a7;
            margin-bottom: 20px;
        }

        .order-box p {
            color: #555;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .order-box .btn-checkout {
            background-color: #e965a7;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .order-box .btn-checkout:hover {
            background-color: #c84d85;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }

        .order-card h5 {
            font-size: 18px;
            color: #333;
        }

        .order-card .list-group-item {
            display: flex;
            justify-content: space-between;
        }

        .order-card .btn {
            padding: 8px 12px;
            font-size: 14px;
        }

        .order-card .btn-outline-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-card .btn-outline-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .order-card .btn-outline-success {
            background-color: #d4edda;
            color: #155724;
        }
        .order-section {
            background-color: #fff0f6;
        }
    </style>
</head>

<body>
    @extends('base.base')

    @section('content')
<div class="order-section">
    <div class="container mt-5">
        <h2 class="fw-bold mb-4" style="color: #e965a7;">My Order</h2>

        <!-- Check if the user has any orders -->
        @if($orders->isEmpty())
        <div class="order-box">
            <h2>Your Orders</h2>
            <p>You haven't checked out yet. Please complete your purchase by going to checkout.</p>
            <a href="{{ route('catalog') }}" class="btn-checkout">Go Checkout</a>
        </div>
        @else
        <!-- Display orders in a list of cards -->
        @foreach($orders as $order)
        <div class="order-card">
            <h5>Order #{{ $order->id }} <span class="text-muted">- {{ $order->created_at->format('d M Y') }}</span></h5>
            <!-- List of items in the order -->
            <ul class="list-group">
                @foreach($order->items as $item)
                <li class="list-group-item">
                    <span>{{ $item->name }}</span>
                    <span>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </li>
                @endforeach
            </ul>

            <!-- Total Price -->
            <div class="mt-3 d-flex justify-content-between">
                <h6>Total:</h6>
                <h6>Rp {{ number_format($order->total, 0, ',', '.') }}</h6>
            </div>

            <!-- Action buttons (Cancel, View Details, Order Received) -->
            <div class="d-flex justify-content-between mt-3">
                <a href="#" class="btn btn-outline-danger">Cancel</a>
                <a href="{{ route('catalog', ['id' => $order->id]) }}" class="btn btn-outline-info">View Details</a>
                <a href="#" class="btn btn-outline-success">Order Received</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
    @endsection

</body>

</html>
