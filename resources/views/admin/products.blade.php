@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4 align-items-center">
            <div class="col">
                <h2 class="fw-bold" style="color: #e965a7;">Products</h2>
                <p class="text-muted m-0">Manage and monitor all products available in your store</p>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-pink d-flex align-items-center" onclick="window.location='{{ route('admin.add-product') }}'">
                    <i class="bi bi-plus-lg me-2"></i> Add Product
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ url()->current() }}">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Search product name..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-search">Search</button>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ request('category', 'all') == 'all' ? 'selected' : '' }}>All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                <option value="all" {{ request('status', 'all') == 'all' ? 'selected' : '' }}>All Status</option>
                                <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ url()->current() }}" class="btn btn-reset"><i class="bi bi-arrow-clockwise"></i> Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
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
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        <span class="badge rounded-pill px-3 py-1 border
                                            @if ($product->stock >= 20) border-success text-success
                                            @elseif ($product->stock > 0) border-warning text-warning
                                            @else border-danger text-danger @endif">
                                            @if ($product->stock >= 20)
                                                In Stock
                                            @elseif($product->stock > 0)
                                                Low Stock
                                            @else
                                                Out of Stock
                                            @endif
                                        </span>
                                    </td>
                                    <td class="d-flex gap-1">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-pink" title="Edit Product">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.delete-product') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($products->isEmpty())
                    <p class="text-muted text-center">No products found.</p>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if ($products->total() == 0)
                            Showing 0 entries
                        @else
                            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        @if ($products->onFirstPage())
                            <button class="btn btn-secondary me-1" disabled>Prev</button>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="btn btn-prev-next me-1">Prev</a>
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
