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

        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
        }
    </style>
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <div>
                    <h2 class="fw-bold" style="color: #e965a7;">Products</h2>
                    <p class="text-muted m-0">Manage and monitor all products available in your store</p>
                </div>
                <button type="button" class="btn text-white add-product"
                    onclick="window.location='{{ route('admin.add-product') }}'"><i class="bi bi-plus-lg"></i> Add
                    Product</button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ url()->current() }}">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search product name..." aria-label="Search" aria-describedby="basic-addon1"
                                    value="{{ request('search') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ request('category', 'all') == 'all' ? 'selected' : '' }}>All
                                    Categories
                                </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Status
                                </option>
                                <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock
                                </option>
                                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock
                                </option>
                                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>
                                    Out of
                                    Stock</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ url()->current() }}" class="btn btn-reset" title="Reset Filter">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

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
                                    <div
                                        class="badge rounded-pill px-3 py-1 border
                                        @if ($product->stock >= 20) border-success
                                        @elseif ($product->stock > 0) border-warning
                                        @else border-danger @endif">

                                        @if ($product->stock >= 20)
                                            <span class="text-success">In Stock</span>
                                        @elseif($product->stock > 0)
                                            <span class="text-warning">Low Stock</span>
                                        @else
                                            <span class="text-danger">Out of Stock</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-edit me-2">
                                        <i class="fas fa-pen" title="Edit Product"></i>
                                    </a>
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($products->isEmpty())
                    <p class="text-muted text-center">No products found.</p>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if ($products->total() == 0)
                            Showing 0 entries
                        @else
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of
                            {{ $products->total() }}
                            entries
                        @endif
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
        </div>
    </div>
@endsection
