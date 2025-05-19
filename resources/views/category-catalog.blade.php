@extends('base.base')

@section('head')
    <!-- Add Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
@endsection

@section('content')
<style>
    .product-section {
        background-color: #fff0f6;
        padding: 40px 0;
        font-family: 'Arial', sans-serif;
    }

    .product-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .product-header h2 {
        color: #e965a7;
        font-size: 36px;
        font-weight: bold;
    }

    .product-header p {
        color: #666;
        font-size: 16px;
        margin-top: 10px;
    }

    .product-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 auto 30px auto;
        max-width: 1100px;
        flex-wrap: wrap;
        gap: 10px;
        padding: 0 20px;
    }

    .product-search input {
        padding: 8px 12px;
        border: 1px solid #e965a7;
        border-radius: 20px;
        width: 220px;
    }

    .product-filters select {
        padding: 8px 12px;
        border-radius: 20px;
        border: 1px solid #e965a7;
        color: #e965a7;
        background-color: #fff;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        padding: 0 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .product-card {
        background-color: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        text-align: center;
        position: relative;
        transition: transform 0.2s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 18px rgba(0,0,0,0.15);
    }

    .product-card img {
        height: 160px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .product-name {
        font-size: 18px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .product-price {
        color: #e965a7;
        font-size: 16px;
        font-weight: bold;
        margin: 5px 0;
    }

    .product-stock {
        font-size: 13px;
        color: #888;
        margin-bottom: 10px;
    }

    .product-description {
        color: #666;
        font-size: 14px;
        height: 38px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: #e965a7;
        color: white;
        padding: 4px 8px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        z-index: 2;
    }

    .wishlist-button {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        z-index: 2;
    }

    .wishlist-button i {
        font-size: 18px;
        color: #e965a7;
    }
</style>

<div class="product-section">
    <div class="product-header">
        <h2>{{ $category }}</h2>
        <p>Explore our selection of high-quality {{ strtolower($category) }} products crafted to fit your needs.</p>
    </div>

    <div class="product-controls">
        <div class="product-search">
            <input type="text" placeholder="Search {{ strtolower($category) }}...">
        </div>
        <div class="product-filters">
            <select>
                <option selected disabled>Sort By</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest First</option>
            </select>
            <select>
                <option selected disabled>Filter</option>
                <option>In Stock</option>
                <option>Out of Stock</option>
            </select>
        </div>
    </div>

    <div class="product-grid">
        @forelse ($products as $product)
            @php
                $isInWishlist = session('id') ? \App\Models\Wishlist::where('user_id', session('id'))
                    ->where('product_id', $product->id)
                    ->exists() : false;
            @endphp
            <div class="product-card" onclick="window.location='{{ route('product.detail', $product->id) }}'">
                <div class="category-label">{{ $category }}</div>

                <!-- Wishlist Heart Button -->
                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="wishlist-button" onclick="event.stopPropagation();">
                    @csrf
                    <button type="submit" class="wishlist-button" title="Add to wishlist">
                        <i class="{{ $isInWishlist ? 'fas' : 'far' }} fa-heart"></i>
                    </button>
                </form>

                <img src="{{ $product->image }}" alt="{{ $product->name }}">
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="product-stock">Stock: {{ $product->stock }}</div>
                <div class="product-description">{{ $product->description }}</div>
            </div>
        @empty
            <p style="text-align: center; width: 100%; color: #888;">No products found.</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Flash Toast -->
    <script>
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
@endsection
