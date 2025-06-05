@extends('base.base')

@section('content')
    <style>
        .payment-section {
            background-color: #fff0f6;
        }

        .payment-section h2 {
            color: #e965a7;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }

        h3 {
            color: #e965a7;
        }
    </style>

    <div class="payment-section">
        <div class="container py-5">
            <h2>Payment Status</h2>

            <div class="p-4 mb-4"
                style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <h5 class="fw-bold text-center">Invoice Number:</h5>
                <h3 class="fw-semibold text-center mb-4">
                    {{ $order->invoice_number }}
                </h3>

                <h5 class="fw-bold text-center">Total Amount:</h5>
                <h3 class="fw-semibold text-center mb-4">
                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                </h3>

                <h5 class="fw-bold text-center">Payment Status:</h5>
                <h4 class="text-center mb-4">
                    <span @class([
                        'badge rounded-pill border px-3 py-1',
                        'border-secondary text-secondary' =>
                            $order->payment->payment_status == 'pending',
                        'border-danger text-danger' => $order->payment->payment_status == 'failed',
                        'border-success text-success' => $order->payment->payment_status == 'paid',
                    ])>
                        {{ ucfirst($order->payment->payment_status) }}
                    </span>
                </h4>

                <p class="text-center text-muted fst-italic mb-4">
                    Payment status has been updated automatically.
                </p>

                <div class="text-center mb-2">
                    <a href="{{ route('my-orders') }}" class="btn rounded-pill px-4"
                        style="background-color: #e965a7; color: white;">
                        Go to My Order
                    </a>
                </div>

                <div class="text-center">
                    <a href="{{ route('order.detail', ['order_id' => $order->id]) }}" class="btn rounded-pill px-4"
                        style="color: #e965a7; border: 1px solid #e965a7;">
                        Go to Order Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
