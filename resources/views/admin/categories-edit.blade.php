@extends('layouts.admin')

@section('content')
<div class="container my-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="fw-bold" style="color: #e965a7;">Edit Category</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card border-0 shadow rounded-4">
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}" placeholder="e.g. Serums" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Brief description of the category"
                                required>{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.categories') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-pink text-white">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

    .form-control:focus {
        border-color: #e965a7;
        box-shadow: 0 0 0 0.25rem rgba(233, 101, 167, 0.25);
    }

    .btn-pinkback {
        background-color: white;
        border: 1px solid #e965a7;
        color: #e965a7;
    }

    .btn-pinkback:hover {
        background-color: #e965a7;
        color: white;
    }
</style>
@endpush
