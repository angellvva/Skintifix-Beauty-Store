@extends('layouts.admin')

@section('content')
    <style>
        .add-product {
            background-color: #e965a7;
            color: white;
        }

        .add-product:hover {
            background-color: #da5195;
            color: white;
        }

        .btn-edit {
            color: #e965a7;
            background-color: white;
            border: 1px solid #e965a7;
        }

        .btn-edit:hover {
            color: white;
            background-color: #e965a7;
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
            width: 45%;
        }

        thead th:nth-child(2) {
            width: 15%;
        }

        thead th:nth-child(3) {
            width: 10%;
        }

        thead th:nth-child(4) {
            width: 10%;
        }

        thead th:nth-child(5) {
            width: 10%;
        }

        thead th:nth-child(6) {
            width: 10%;
        }

        tbody td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold mb-0">Products</h2>
                    <p class="text-muted mb-0">Manage and monitor all products available in your store</p>
                </div>
                <button type="button" class="btn text-white add-product"><i class="bi bi-plus-lg"></i> Add Product</button>
            </div>
        </div>

        <div class="row g-3 mb-3 align-items-center">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" placeholder="Search products..." aria-label="Search"
                        aria-describedby="basic-addon1" />
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select">
                    <option selected>All Categories</option>
                    {{-- loop kategori dinamis di sini --}}
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
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
                                <button type="submit" class="btn btn-outline-danger" title="Hapus produk">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
            </div>

            {{-- Pagination links --}}
            <div class="d-flex justify-content-end">
                @if ($products->onFirstPage())
                    <button class="btn btn-secondary me-1" disabled>Prev</button>
                @else
                    <a href="{{ $products->previousPageUrl() }}" class="btn btn-prev-next me-1"
                        style="margin-right: 4px;">Prev</a>
                @endif

                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}" class="btn btn-prev-next ms-1">Next</a>
                @else
                    <button class="btn btn-secondary ms-1" disabled>Next</button>
                @endif
            </div>
        </div>
    </div>
@endsection
