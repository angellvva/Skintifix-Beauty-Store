@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Orders</h2>
                <p class="text-muted m-0">Track and process customer orders efficiently</p>
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
        <div class="card">
            <div class="card-body">
                <form method="GET" id="filterForm">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search orders ID..."
                                    value="{{ request('search') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="sort" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Newest
                                    First</option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First
                                </option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ url()->current() }}" class="btn btn-reset">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <table class="table align-middle">
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
                                <td class="fw-bold">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>

                                @if ($order->orderItems->sum('quantity') <= 1)
                                    <td>{{ $order->orderItems->sum('quantity') }} item</td>
                                @else
                                    <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                @endif

                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    <span
                                        class="badge 
                                    @if ($order->status == 'Pending') bg-warning text-dark
                                    @elseif($order->status == 'Processing') bg-primary
                                    @elseif($order->status == 'Shipped') bg-info
                                    @elseif($order->status == 'Delivered') bg-success
                                    @elseif($order->status == 'Cancelled') bg-danger @endif">
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

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if ($orders->total() == 0)
                            Showing 0 entries
                        @else
                            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of
                            {{ $orders->total() }}
                            entries
                        @endif
                    </div>

                    {{-- Pagination links --}}
                    <div class="d-flex justify-content-end">
                        @if ($orders->onFirstPage())
                            <button class="btn btn-secondary me-1" disabled>Prev</button>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" class="btn btn-prev-next me-1"
                                style="margin-right: 4px;">Prev</a>
                        @endif

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="btn btn-prev-next ms-1">Next</a>
                        @else
                            <button class="btn btn-secondary ms-1" disabled>Next</button>
                        @endif
                    </div>
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

        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
        }

        .btn-prev-next {
            color: white;
            background-color: #e965a7;
        }

        .btn-prev-next:hover {
            color: white;
            background-color: #da5195;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        thead th:nth-child(1) {
            width: 15%;
        }

        thead th:nth-child(2) {
            width: 20%;
        }

        thead th:nth-child(3) {
            width: 15%;
        }

        thead th:nth-child(4) {
            width: 15%;
        }

        thead th:nth-child(5) {
            width: 15%;
        }

        thead th:nth-child(6) {
            width: 10%;
        }

        thead th:nth-child(7) {
            width: 10%;
        }
    </style>
@endpush
