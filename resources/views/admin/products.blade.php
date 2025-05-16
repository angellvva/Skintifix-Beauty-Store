@extends('layouts.admin')

@section('content')
    <style>
        .btn {
            background-color: #e965a7;
        }

        .btn:hover {
            background-color: #da5195;
        }
    </style>
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold mb-0">Products</h2>
                    <p class="text-muted mb-0">Manage and monitor all products available in your store</p>
                </div>
                <button type="button" class="btn text-white"><i class="bi bi-plus-lg"></i> Add Product</button>
            </div>
        </div>

        <div class="row g-3 mb-3 align-items-center">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search products..." />
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option selected>All Categories</option>
                    {{-- Bisa loop kategori dinamis di sini --}}
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option selected>All Status</option>
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div>
        </div>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}
                        <td>{{ $product->stock }}</td>
                        <td>
                            @if ($product->stock > 20)
                                <span class="badge-in-stock">In Stock</span>
                            @elseif($product->stock > 0)
                                <span class="badge-low-stock">Low Stock</span>
                            @else
                                <span class="badge-out-stock">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <a href="" class="btn btn-edit me-2">Edit</a>
                            <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination links --}}
    </div>
@endsection
