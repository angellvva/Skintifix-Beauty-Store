@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="mb-4 d-flex align-items-center">
        <a href="{{ route('admin.orders') }}" class="btn btn-light me-3">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h4 class="fw-bold" style="color: #e965a7;">
            Order SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
            <span class="badge rounded-pill ms-2 px-3 py-1 border
                @if ($order->status == 'pending') border-warning text-warning
                @elseif($order->status == 'processing') border-primary text-primary
                @elseif($order->status == 'completed') border-success text-success
                @else border-secondary text-secondary @endif">
                {{ ucfirst($order->status) }}
            </span>
        </h4>
    </div>

    <div class="row">
        <!-- Order Details -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header fw-semibold">Order Details</div>
                <div class="card-body">
                    <p class="text-muted mb-4">
                        Placed on {{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }} | SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                    </p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr class="align-middle">
                                    <td>
                                        <img src="{{ $item->product->image }}"
                                            class="img-fluid"
                                            style="height: 70px;">
                                    </td>
                                    <td>{{ $item->product->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end">Subtotal:</td>
                                <td>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Shipping:</td>
                                <td>Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="fw-bold">
                                <td colspan="4" class="text-end">Total:</td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-4">
            <!-- Customer Info -->
            <div class="card mb-3">
                <div class="card-header fw-semibold">Customer Information</div>
                <div class="card-body">
                    <p class="mb-1 fw-bold">{{ $order->user->name }}</p>
                    <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $order->user->email }}</p>
                    <p class="mb-0"><i class="fas fa-phone me-2"></i>{{ $order->user->phone ?? '-' }}</p>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card mb-3">
                <div class="card-header fw-semibold">Shipping Address</div>
                <div class="card-body">
                    <p class="mb-0 fw-bold">{{ $order->user->name }}</p>
                    <p class="mb-0">{{ $order->user->phone ?? '-' }}</p>
                    <p class="mb-0">{{ $order->user->address ?? '-' }}</p>
                    <p class="mb-0">POSTAL CODE</p>
                    <p class="mb-0">CITY</p>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="card">
                <div class="card-header fw-semibold">Payment Information</div>
                <div class="card-body">
                    <p><strong>Status:</strong> 
                        @if (isset($order->payment) && $order->payment->payment_status == 'paid')
                            <span class="badge rounded-pill border border-success text-success">Paid</span>
                        @else
                            <span class="badge rounded pill border border-danger text-danger">Failed</span>
                        @endif
                    </p>
                    <p><strong>Method:</strong> {{ $order->payment->payment_method }}</p>
                    <p class="mb-0"><strong>Amount:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-header {
        background-color: #e965a7;
        color: white;
        font-weight: 600;
    }
</style>

</style>
@endpush