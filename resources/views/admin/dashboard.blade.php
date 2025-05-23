@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Dashboard</h2>
                <p class="text-muted m-0">Overview of your store performance</p>
            </div>
        </div>

        <div class="row">
            <!-- Total Orders -->
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.orders') }}" class="text-decoration-none text-white">
                    <div class="card stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Total Orders</h6>
                                <h2 class="fw-bold mb-0">{{ $totalOrders }}</h2>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-shopping-cart fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Revenue -->
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.orders') }}" class="text-decoration-none text-white">
                    <div class="card stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Total Revenue</h6>
                                <h2 class="fw-bold mb-0">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-money-bill-wave fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Total Products -->
            <div class="col-lg-4 mb-4">
                <a href="{{ route('admin.products') }}" class="text-decoration-none text-white">
                    <div class="card stat-card gradient-pink text-white rounded-4 h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-uppercase fw-semibold mb-1">Total Products</h6>
                                <h2 class="fw-bold mb-0">{{ $totalProducts }}</h2>
                            </div>
                            <div class="icon-circle">
                                <i class="fas fa-boxes fa-lg"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row d-flex">
            <!-- Recent Orders -->
            <div class="col-md-8 mb-4 d-flex flex-column">
                <div class="card flex-grow-1 d-flex flex-column">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentOrders as $order)
                                        <tr>
                                            <td>SKINTIFIX-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $order->order_date }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-pink mt-2">View All
                            Orders</a>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="col-md-4 mb-4 d-flex flex-column">
                <div class="card flex-grow-1 d-flex flex-column">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Low Stock Products</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 70%">Name</th>
                                    <th style="width: 30%">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockProducts as $product)
                                    <tr>
                                        <td class="text-truncate-1line me-2">{{ $product->name }}</td>
                                        <td>{{ $product->stock }} left</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($lowStockProducts->isEmpty())
                            <p class="text-muted text-center">No products found.</p>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if ($lowStockProducts->total() == 0)
                                    Showing 0 entries
                                @else
                                    Showing {{ $lowStockProducts->firstItem() }} to
                                    {{ $lowStockProducts->lastItem() }} of
                                    {{ $lowStockProducts->total() }}
                                    entries
                                @endif
                            </div>

                            {{-- Pagination links --}}
                            <div class="d-flex justify-content-end">
                                @if ($lowStockProducts->onFirstPage())
                                    <button class="btn btn-secondary me-1" disabled>Prev</button>
                                @else
                                    <a href="{{ $lowStockProducts->previousPageUrl() }}" class="btn btn-prev-next me-1"
                                        style="margin-right: 4px;">Prev</a>
                                @endif

                                @if ($lowStockProducts->hasMorePages())
                                    <a href="{{ $lowStockProducts->nextPageUrl() }}"
                                        class="btn btn-prev-next ms-1">Next</a>
                                @else
                                    <button class="btn btn-secondary ms-1" disabled>Next</button>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-pink mt-3">Manage
                            Products</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Top Selling Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table topselling">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Unit Solds</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topSellingProducts as $product)
                                        <tr>
                                            <td class="text-truncate-1line">{{ $product->product_name }}
                                            </td>
                                            <td>{{ $product->category_name }}</td>
                                            <td>Rp {{ number_format($product->product_price, 0, ',', '.') }}</td>
                                            <td>{{ $product->total_quantity }}</td>
                                            <td>{{ $product->product_stock }}</td> {{-- stock harus ditambah di select query --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <a href="{{ route('admin.products') }}" class="btn btn-sm btn-pink mt-2">View All
                                Products</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Sales Over Time</h5>
                        <form action="{{ route('admin.dashboard') }}" method="GET" class="row g-3 align-items-end mb-4">
                            <div class="col-md-2">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" id="start_date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" id="end_date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-pink w-100">Filter</button>
                            </div>
                        </form>
                        <div class="card-body">
                            <canvas id="salesChart" height="60"></canvas>
                        </div>
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

        .text-truncate-1line {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 100%;
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

        .topselling th:nth-child(1) {
            width: 40%;
        }

        .topselling th:nth-child(2) {
            width: 20%;
        }

        .topselling th:nth-child(3) {
            width: 15%;
        }

        .topselling th:nth-child(4) {
            width: 10%;
        }

        .topselling th:nth-child(5) {
            width: 10%;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesLabels) !!},
                datasets: [{
                    label: 'Total Sales',
                    data: {!! json_encode($salesCounts) !!},
                    borderColor: '#e965a7',
                    backgroundColor: '#e965a7',
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 10,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value;
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Orders',
                            color: '#e965a7',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                            color: '#e965a7',
                            font: {
                                size: 16,
                                weight: 'bold'
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
