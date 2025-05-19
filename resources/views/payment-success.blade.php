@extends('base.base')

@section('content')
<div style="background-color: #fff0f6; min-height: 100vh; padding: 3rem 0;">
    <div class="container d-flex justify-content-center">
        <div class="card shadow-sm rounded-4 p-5" style="max-width: 480px; border: 1px solid #e965a7;">
            <h2 class="fw-bold mb-4 text-center" style="color: #e965a7;">
                <i class="fas fa-check-circle me-2"></i>Payment Status
            </h2>

            <div class="mb-3 text-center">
                <p class="fs-5 mb-1"><strong>Order Number:</strong></p>
                <p class="fs-4 fw-semibold">
                    <td>SKINTIFIX-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</td>
                </p>
            </div>

            <div class="mb-3 text-center">
                <p class="fs-5 mb-1"><strong>Total Amount:</strong></p>
                <p class="fs-4 fw-semibold">Rp {{ number_format($payment->total_amount, 0, ',', '.') }}</p>
            </div>

            <div class="mb-4 text-center">
                <p class="fs-5 mb-1"><strong>Payment Status:</strong></p>
                <p class="fs-4 fw-semibold text-success">{{ ucfirst($payment->status) }}</p>
            </div>

            <p class="text-center text-muted fst-italic">
                Payment status has been updated automatically.
            </p>

            <div class="text-center mt-4">
                <a href="{{ route('my-orders') }}" class="btn rounded-pill px-4" style="background-color: #e965a7; color: white;">
                    Go to Order
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
