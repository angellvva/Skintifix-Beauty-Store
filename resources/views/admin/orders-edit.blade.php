@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Update Order <span class="text-pink">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            <span class="badge 
                @if ($order->status == 'pending') text-warning border border-warning
                @elseif($order->status == 'processing') text-primary border border-primary
                @elseif($order->status == 'completed') text-success border border-success
                @else text-secondary border border-secondary
                @endif
                fw-semibold px-3 py-1 rounded-pill bg-white">
                {{ ucfirst($order->status) }}
            </span></h4>
        </div>
        <div>
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-secondary me-2">Cancel</a>
            <button form="orderUpdateForm" class="btn btn-pink">
                <i class="bi bi-save me-1"></i> Save Changes
            </button>
        </div>
    </div>

    {{-- <form action="#" method="POST" id="orderUpdateForm"> --}}
    <form action="{{ route('orders.update', $order->id) }}" method="POST" id="orderUpdateForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Order Status -->
            <div class="col-md-6">
                <div class="card rounded-4 border">
                    <div class="card-header fw-semibold">Order Status</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select">
                                <option value="paid" {{ optional($order->payment)->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="failed" {{ optional($order->payment)->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Shipping Info -->
            <div class="col-md-6">
                <div class="card rounded-4 border">
                    <div class="card-header fw-semibold">Shipping Information</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="shipping_date" class="form-label">Shipping Date</label>
                            <input type="date" name="shipping_date" id="shipping_date" class="form-control" value="{{ old('shipping_date') }}">
                        </div>
                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Estimated Delivery Date</label>
                            <input type="date" name="delivery_date" id="delivery_date" class="form-control" value="{{ old('delivery_date') }}">
                        </div>
                        <div class="mb-3">
                            <label for="received_date" class="form-label">Received Date</label>
                            <input type="date" name="received_date" id="received_date" class="form-control" value="{{ old('received_date') }}">
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .text-pink {
        color: #e965a7;
    }
    .btn-pink {
        background-color: #e965a7;
        color: white;
        border: none;
    }
    .btn-pink:hover {
        background-color: #da5195;
    }

    .card-header {
        background-color: #e965a7;
        color: white;
        font-weight: 600;
    }
</style>
@endpush