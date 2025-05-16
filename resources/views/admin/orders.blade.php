@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Orders</h2>
                <p class="text-muted">Track and process customer orders efficiently</p>
            </div>
        </div>

        <!-- Status Summary Cards -->
        <div class="row my-4">
            <div class="col-md-3">
                <div class="card card-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Total Orders</div>
                        <h3 class="mb-0">{{ number_format($orders->total()) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Pending</div>
                        <h4 class="mb-0">{{ $orders->where('status', 'Pending')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Processing</div>
                        <h4 class="mb-0">{{ $orders->where('status', 'Processing')->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Completed</div>
                        <h4 class="mb-0">{{ $orders->where('status', 'Completed')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Table -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <input type="text" class="form-control w-25" placeholder="Search orders...">
                    <div>
                        <select class="form-select d-inline-block w-auto me-2">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Processing</option>
                            <option>Completed</option>
                        </select>
                        <select class="form-select d-inline-block w-auto">
                            <option>Newest First</option>
                            <option>Oldest First</option>
                        </select>
                    </div>
                </div>

                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Products</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                            <td>{{ $order->orderItems->sum('quantity') }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status == 'Pending') bg-warning text-dark
                                    @elseif($order->status == 'Processing') bg-primary
                                    @elseif($order->status == 'Shipped') bg-info
                                    @elseif($order->status == 'Delivered') bg-success
                                    @elseif($order->status == 'Cancelled') bg-danger
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-pink">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-end">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
        .btn-pink {
            color: #e965a7;
            background-color: white;
            border: 1px solid #e965a7;
        }

        .btn-pink:hover {
            background-color: #da5195;
            color: white;
        }

.card-pink {
    background-color: #e965a7;
    border: none;
    color: white;
}

.card-pink .small,
.card-pink h3,
.card-pink h4,
.card-pink .card-body {
    color: white;
}
</style>
@endpush
