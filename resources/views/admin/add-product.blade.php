@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Add Product</h2>
                <p class="text-muted m-0">Create and publish new products to your store catalog</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Hydrating Serum"
                                required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Price (Rp)</label>
                            <input type="number" name="price" class="form-control" placeholder="e.g. 149000"
                                step="500" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stock</label>
                            <input type="number" name="stock" class="form-control" placeholder="e.g. 10" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Product Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Describe the product..." required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Product Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Recommended size: 400x400px</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-pink text-white"><i class="bi bi-save me-1"></i> Save
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

        .btn-outline-pink {
            border: 1px solid #e965a7;
            color: #e965a7;
            background-color: white;
        }

        .btn-outline-pink:hover {
            background-color: #e965a7;
            color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #e965a7;
            box-shadow: 0 0 0 0.25rem rgba(233, 101, 167, 0.25);
        }
    </style>
@endpush
