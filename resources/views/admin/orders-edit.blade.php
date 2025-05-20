@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="d-flex align-items-center mb-4" >
        <div class="me-auto">
            <h4 class="fw-bold mb-0">Update Order <span class="text-pink">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
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
    </div>

    {{-- <form action="#" method="POST" id="orderUpdateForm"> --}}
    <form action="{{ route('orders.update', $order->id) }}" method="POST" id="orderUpdateForm">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <!-- Order Status -->
            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">
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

                        <!-- Tombol diletakkan di dalam card-body -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.orders') }}" class="btn btn-secondary px-4">Cancel</a>
                            <button form="orderUpdateForm" class="btn btn-pink px-4 text-white">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
        transition: all 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #da5195;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        color: white;
    }
    .card-header {
        background-color: #e965a7;
        color: white;
        font-weight: 600;
    }

    .card {
        border-radius: 1rem !important;
    }
</style>
@endpush