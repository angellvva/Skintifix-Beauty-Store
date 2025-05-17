@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Categories</h2>
                <p class="text-muted m-0">Organize your products into clear and manageable categories</p>
            </div>
        </div>
        <div class="row">
            <!-- Left side: Table -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table align-middle">
                            <thead class="table">
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="fw-semibold">{{ $category->name }}</td>
                                        <td>{{ Str::limit($category->description, 50) }}</td>
                                        <td class="text-center">{{ $category->products_count }}</td>
                                        <td>
                                            <div class="d-flex gap-1 align-items-center">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('categories.edit', ['id' => $category->id]) }}"
                                                class="btn btn-sm btn-outline-pink">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                {{-- Delete Button --}}
                                                <form method="POST" action="{{ route('category.remove') }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                    <button type="submit"
                                                                class="btn btn-sm btn-outline-red"
                                                                style="color: #dc3545;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if ($categories->isEmpty())
                            <p class="text-muted text-center">No categories found.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right side: Form -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Add New Category</h5>
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Eye Care" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Brief description..." required></textarea>
                            </div>
                            <button type="submit" class="btn w-100" style="background-color:#e965a7; color:white;">
                                Create Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn-outline-pink {
            border: 1px solid #e965a7;
            color: #e965a7;
            background-color: white;
        }

        .btn-outline-red {
            border: 1px solid red;
            color: #e965a7;
            background-color: white;
        }

        .btn-outline-pink:hover {
            background-color: #e965a7;
            color: white;
        }
    </style>
@endpush
