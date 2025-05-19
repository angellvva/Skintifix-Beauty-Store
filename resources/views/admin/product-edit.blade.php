@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Edit Product</h2>
                <p class="text-muted m-0">Update products to keep your store information accurate and up to date</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $product->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rp)</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ old('price', number_format($product->price, 0, '.', '')) }}" step="500"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control"
                                value="{{ old('stock', $product->stock) }}" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Product Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave blank if not changing the image.</small>
                            @if ($product->image)
                                <div class="mt-2">
                                    <img src="{{ $product->image }}" alt="Current Image" width="100">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-pink text-white"><i class="bi bi-save me-1"></i> Update
                            Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-pink {
            background-color: #e965a7;
            border: none;
        }

        .btn-pink:hover {
            background-color: #da5195;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #e965a7;
            box-shadow: 0 0 0 0.25rem rgba(233, 101, 167, 0.25);
        }
    </style>
@endpush
