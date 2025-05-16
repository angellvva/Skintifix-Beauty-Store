@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Dashboard</h2>
                <p class="text-muted">Overview of your store performance</p>
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
                    <div class="card stat-card gradient-green text-white rounded-4 h-100">
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
                    <div class="card stat-card gradient-blue text-white rounded-4 h-100">
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

        <div class="row">
            <!-- Recent Orders -->
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
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
                        <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-outline-primary mt-2">View All
                            Orders</a>
                    </div>
                </div>
            </div>

            <!-- Low Stock Products -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Low Stock Products</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($lowStockProducts as $product)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $product->name }}
                                    <span class="badge bg-{!! $product->stock <= 0 ? 'danger' : ($product->stock <= 10 ? 'warning' : 'success') !!}">
                                        {{ $product->stock }} left
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-primary mt-3">Manage
                            Products</a>
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

        .gradient-green {
            background: linear-gradient(135deg, #28a745, #218838);
        }

        .gradient-blue {
            background: linear-gradient(135deg, #1E90FF, #4682B4);
        }

        .icon-circle {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }
    </style>
@endpush
