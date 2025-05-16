@extends('layouts.admin') {{-- ganti dengan layout utama kamu, misalnya 'layouts.app' jika pakai default --}}

@section('title', 'Dashboard - Skintifix Beauty Store Admin')
@section('content')
<div class="container-fluid pt-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Orders</h5>
                    <p class="card-text display-6">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text display-6">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Products</h5>
                    <p class="card-text display-6">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">New Customers</h5>
                    <p class="card-text display-6">{{ $newCustomers }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Recent Orders</h5>
            <a href="{{ url('/admin/orders') }}" class="btn btn-outline-primary btn-sm">View All Orders</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr>
                            <td>SKINTIFIX-2025-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $order->order_date }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Low Stock Products</h5>
            <a href="{{ url('/admin/products') }}" class="btn btn-outline-primary btn-sm">Manage Products</a>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <span class="badge bg-{{
                                    $product->stock <= 0 ? 'danger' :
                                    ($product->stock <= 3 ? 'warning' : 'success')
                                }}">
                                    {{ $product->stock <= 0 ? 'Out of stock' : ($product->stock <= 3 ? 'Low Stock' : 'In Stock') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection