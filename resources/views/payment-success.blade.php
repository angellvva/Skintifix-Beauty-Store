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
    </style>

    <div class="payment-section">
        <div class="container py-5">
            <h2>Payment Status</h2>

            <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div class="table-responsive text-center py-5">
                    <div class="mb-3 text-center">
                        <p class="fs-5 mb-1"><strong>Order Number:</strong></p>
                        <p class="fs-4 fw-semibold">
                            {{ $order->invoice_number }}                
                        </p>
                    </div>

                    <div class="mb-3 text-center">
                        <p class="fs-5 mb-1"><strong>Total Amount:</strong></p>
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </div>

                    <div class="mb-4 text-center">
                        <p class="fs-5 mb-1"><strong>Payment Status:</strong></p>
                            {{ ucfirst($order->status) }}
                    </div>

                    @if (isset($status_message))
                        <p class="text-center text-muted fst-italic">{{ $status_message }}</p>
                    @endif

                    <p class="text-center text-muted fst-italic">
                        Payment status has been updated automatically.
                    </p>

                    <div class="text-center mt-4">
                        <a href="{{ route('my-orders') }}" class="btn rounded-pill px-4"
                            style="background-color: #e965a7; color: white;">
                            Go to Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
