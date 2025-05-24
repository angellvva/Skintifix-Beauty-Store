@extends('base.base')

@section('content')
    <style>
        .order-detail-card {
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            background-color: white;
            width: 100%;
            position: relative;
        }

        .back-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 2;
            border: 1px solid #e965a7;
            color: #e965a7;
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .back-icon:hover {
            background-color: #e965a7;
            color: white;
        }

        .order-product-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .order-product-item {
            display: flex;
            gap: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .order-product-item img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 12px;
        }

        .order-product-item-details {
            flex: 1;
        }

        .order-product-item-details p {
            margin: 5px 0;
        }

        .fas.fa-star {
            color: #ddd;
        }

        .fas.fa-star.active {
            color: #ffc107;
        }

        .order-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            justify-content: space-between;
        }

        .order-summary .summary-block {
            flex: 1;
            min-width: 200px;
        }

        .order-summary .summary-block p {
            margin: 4px 0;
        }

        .order-total {
            font-size: 18px;
            margin-bottom: 12px;
            text-align: right;
        }

        .order-detail-section {
            background-color: #fff0f6;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .customer-info-table th:nth-child(1) {
            width: 20%;
        }

        .customer-info-table th:nth-child(2) {
            width: 25%;
        }

        .customer-info-table th:nth-child(3) {
            width: 55%;
        }

        .order-img {
            width: 100%;
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="order-detail-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">Order Details</h2>

            <div class="p-4 mb-4"
                style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h5 class="fw-bold ps-2" style="color:#e965a7;">Customer & Shipping Information</h5>
                <table class="table customer-info-table">
                    <thead>
                        <tr>
                            <th>Customer Details</th>
                            <th>Contact Information</th>
                            <th>Shipping Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <p class="fw-bold m-0">{{ $order->user->name }}</p>
                                <p class="m-0" style="color:gray;">Customer ID:
                                    CUST-{{ str_pad($order->user->id, 5, '0', STR_PAD_LEFT) }}
                                </p>
                            </td>
                            <td>
                                <p class="m-0">
                                    <span><i class="fas fa-phone me-2"
                                            style="color:#e965a7;"></i></span>{{ $order->user->phone }}
                                </p>
                                <p class="m-0">
                                    <span><i class="fas fa-envelope me-2"
                                            style="color:#e965a7;"></i></span>{{ $order->user->email }}
                                </p>
                            </td>
                            <td>{{ $order->user->address }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4 mb-4"
                style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h5 class="fw-bold ps-2" style="color:#e965a7;">Order Details</h5>
                <table class="table order-details-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Payment Method</th>
                            <th>Shipping Method</th>
                            <th>Order Date</th>
                            <th>Shipping Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b style="color:#e965a7;">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</b></td>
                            <td>{{ ucwords($order->payment->payment_method) }}<br>
                                <span @class([
                                    'badge rounded-pill border px-3 py-1',
                                    'border-danger text-danger' => $order->payment->payment_status == 'failed',
                                    'border-success text-success' => $order->payment->payment_status == 'paid',
                                ])>
                                    {{ ucfirst($order->payment->payment_status) }}
                                </span>
                            </td>
                            <td>
                                Standard Delivery<br>
                                <p class="m-0" style="color:gray;">3 business days</p>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}<br>
                                <p class="m-0" style="color:gray;">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('H:i') }}</p>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($order->created_at)->addDays(3)->format('d M Y') }}<br>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($order->created_at)->addDays(6)->format('d M Y') }}<br>
                            </td>
                            <td>
                                <div @class([
                                    'badge rounded-pill border px-3 py-1',
                                    'border-secondary text-secondary' => $order->status == 'pending',
                                    'border-warning text-warning' => $order->status == 'processing',
                                    'border-success text-success' => $order->status == 'completed',
                                ])>
                                    {{ ucfirst($order->status) }}
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-4"
                style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h5 class="fw-bold ps-2" style="color:#e965a7;">Order Summary</h5>
                <table class="table order-details-table">
                    <tbody>
                        @php
                            $totalOrderPrice = 0;
                        @endphp

                        @foreach ($order->orderItems as $orderItem)
                            @php
                                $subtotal = $orderItem->product->price * $orderItem->quantity;
                                $totalOrderPrice += $subtotal;
                            @endphp

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-md-1">
                                            <img src="{{ $orderItem->product->image }}"
                                                alt="{{ $orderItem->product->name }}" class="order-img">
                                        </div>
                                        <div class="col-md-9 p-0">
                                            <p class="fw-bold mb-1">{{ $orderItem->product->name }}</p>
                                            <p class="mb-0">Amount: {{ $orderItem->quantity }}</p>
                                        </div>
                                        <div class="col-md-2" style="text-align: right;">
                                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="row align-items-center">
                    <div class="col-md-10 text-end">
                        Subtotal (<span>{{ count($order->orderItems) }}</span>
                        @if (count($order->orderItems) > 1)
                            items)
                        @else
                            item)
                        @endif
                    </div>
                    <div class="col-md-2" style="text-align: right;">
                        <p class="m-0 fw-bold">Rp{{ number_format($totalOrderPrice, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-10 text-end">
                        Shipping
                    </div>
                    <div class="col-md-2" style="text-align: right;">
                        <p class="m-0 fw-bold">Rp{{ number_format($order->shipping_price, 0, ',', '.') }}</p>
                    </div>
                </div>

                <br>

                <div class="row align-items-center">
                    <div class="col-md-10 text-end">
                        Total Amount
                    </div>
                    <div class="col-md-2" style="text-align: right; color:#e965a7;">
                        <h4 class="m-0 fw-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
