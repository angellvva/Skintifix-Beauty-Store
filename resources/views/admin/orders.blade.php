@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Orders</h2>
                <p class="text-muted m-0">Track and process customer orders efficiently</p>
            </div>
        </div>

        <!-- Status Summary Cards -->
        <div class="row">
            <!-- Total Orders -->
            <div class="col-12 col-md-3">
                <div class="text-decoration-none text-white">
                    <div class="card mb-4 stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Total Orders</h6>
                                <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                            </div>
                            <div class="icon-circle flex-shrink-0 ms-3">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-12 col-md-3">
                <div class="text-decoration-none text-white">
                    <div class="card mb-4 stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Pending</h6>
                                <h2 class="fw-bold mb-0">{{ $totalPending }}</h2>
                            </div>
                            <div class="icon-circle flex-shrink-0 ms-3">
                                <i class="fas fa-hourglass-start fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Processing -->
            <div class="col-12 col-md-3">
                <div class="text-decoration-none text-white">
                    <div class="card mb-4 stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Processing</h6>
                                <h2 class="fw-bold mb-0">{{ $totalProcessing }}</h2>
                            </div>
                            <div class="icon-circle flex-shrink-0 ms-3">
                                <i class="fas fa-sync-alt fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="col-12 col-md-3">
                <div class="text-decoration-none text-white">
                    <div class="card mb-4 stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Completed</h6>
                                <h2 class="fw-bold mb-0">{{ $totalCompleted }}</h2>
                            </div>
                            <div class="icon-circle flex-shrink-0 ms-3">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Table -->
        <div class="card">
            <div class="card-body table-responsive">
                <form method="GET" id="filterForm">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search order ID..."
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
                                <td class="fw-bold">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>

                                @if ($order->orderItems->sum('quantity') <= 1)
                                    <td>{{ $order->orderItems->sum('quantity') }} item</td>
                                @else
                                    <td>{{ $order->orderItems->sum('quantity') }} items</td>
                                @endif

                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>
                                    @if ($order->status)
                                        <span
                                            class="badge rounded-pill px-3 py-1 border
                                            @if ($order->status == 'pending') border-warning text-warning
                                            @elseif($order->status == 'processing') border-primary text-primary
                                            @elseif($order->status == 'completed') border-success text-success
                                            @else border-secondary text-secondary @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    @else
                                        <span
                                            class="badge rounded-pill border border-secondary text-secondary px-3 py-1">Unknown</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-pink"
                                        title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-pink"
                                        title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($orders->isEmpty())
                    <p class="text-muted text-center">No orders found.</p>
                @endif

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
        .gradient-pink {
            background: linear-gradient(135deg, #e965a7, #ffb3d6);
        }

        .icon-circle {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .btn-pink {
            color: #e965a7;
            background-color: white;
            border: 1px solid #e965a7;
        }

        .btn-pink:hover {
            background-color: #da5195;
            color: white;
        }

        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            white-space: nowrap;
            width: auto;
            padding: 0.375rem 0.75rem;
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

        /* Untuk bagian tombol action */
        td.d-flex.gap-1 {
            flex-wrap: nowrap !important;
            /* Pastikan tombol tidak pindah ke bawah */
            gap: 0.25rem;
        }

        /* Membuat kolom tidak wrap ke bawah */
        .table thead th {
            white-space: nowrap;
        }

        /* Memastikan scroll horizontal jika layar kecil */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Agar teks dalam table tidak kepotong */
        .table td {
            white-space: nowrap;
        }

        /* Responsif di layar kecil */
        @media (max-width: 768px) {
            table {
                min-width: 700px;
                /* cukup lebar untuk semua kolom */
            }

            .table-responsive {
                border: 1px solid #dee2e6;
            }

            thead th:nth-child(6),
            /* Status */
            thead th:nth-child(7) {
                /* Actions */
                min-width: 120px;
            }

            td:nth-child(6),
            td:nth-child(7) {
                min-width: 120px;
            }
        }
    </style>
@endpush
