@extends('layouts.admin')

@section('content')
    <style>
        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        thead th:nth-child(1) {
            width: 20%;
        }

        thead th:nth-child(2) {
            width: 55%;
        }

        thead th:nth-child(3) {
            width: 15%;
        }

        thead th:nth-child(4) {
            width: 10%;
        }
    </style>
    @if (session('success'))
        <div id="category-notification" class="alert alert-success"
            style="
                transition: opacity 0.3s ease;
                position: fixed;
                top: 50px;
                right: 275px;
                background-color: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
                border-radius: 8px;
                padding: 10px 20px;
                z-index: 9999;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
                min-width: 250px;
            ">
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('category-notification').remove();"
                style="
                    transition: opacity 0.3s ease;
                    background: transparent;
                    border: none;
                    color: #155724;
                    font-weight: bold;
                    font-size: 20px;
                    margin-left: 15px;
                    cursor: pointer;
                "
                aria-label="Close notification">&times;</button>
        </div>
    @endif
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Categories</h2>
                <p class="text-muted m-0">Organize your products into clear and manageable categories</p>
            </div>
        </div>
        <div class="row">
            <!-- Left side: Table -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        {{-- Search Form --}}
                        <form method="GET" action="{{ url()->current() }}">
                            <div class="row g-3 mb-3 align-items-center">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Search category name..." value="{{ request('search') }}" />
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <a href="{{ url()->current() }}" class="btn btn-reset">
                                        <i class="bi bi-arrow-clockwise"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>

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
                                                    <i class="fas fa-pen" title="Edit Category"></i>
                                                </a>
                                                {{-- Delete Button --}}
                                                <form method="POST" action="{{ route('category.remove') }}"
                                                    class="m-0 delete-category-form" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                    @csrf
                                                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-red">
                                                        <i class="fas fa-trash" title="Delete Category"></i>
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Add New Category</h5>
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Eye Care"
                                    required>
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
        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            white-space: nowrap;
            width: auto;
            padding: 0.375rem 0.75rem;
        }

        .btn-outline-pink {
            border: 1px solid #e965a7;
            color: #e965a7;
            background-color: white;
        }

        .btn-outline-red {
            border: 1px solid red;
            color: red;
            background-color: white;
        }

        .btn-outline-pink:hover {
            background-color: #e965a7;
            color: white;
        }

        .btn-outline-red:hover {
            background-color: red;
            color: white;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-hide notification after 5 seconds
        setTimeout(() => {
            const notification = document.getElementById('category-notification');
            if (notification) {
                notification.style.opacity = '0';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 3000);
    </script>
@endpush
