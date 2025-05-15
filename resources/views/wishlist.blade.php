@extends('base.base')

@section('content')
<style>
    h2 {
        margin-left: 60px;
        margin-top: 20px;
    }

    .item-desc {
        margin-left: 60px;
        margin-bottom: 30px;
    }

    .wishlist-container {
        margin-left: 60px;
        margin-right: 20px;
        margin-bottom: 60px;
    }

    .wishlist-card {
        border: 2px solid #e965a7 !important;
        transition: all 0.3s ease;
        width: 260px;
        border-radius: 8px;
    }

    .wishlist-card:hover {
        box-shadow: 0 0 15px rgba(233, 101, 167, 0.5);
        transform: translateY(-5px);
        z-index: 1;
    }

    .wishlist-img {
        height: 160px;
        object-fit: contain;
        margin-bottom: 1rem;
    }

    .wishlist-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px 10px;
    }

    .empty-wishlist-icon {
        font-size: 60px;
        color: #ccc;
    }

    .empty-wishlist-text {
        font-weight: 500;
        color: #555;
    }

    .empty-wishlist-container {
        padding-top: 100px;
        padding-bottom: 100px;
        text-align: center;
    }
</style>

<h2 class="mb-2">My Wishlist</h2>
<p class="item-desc text-muted">
    You have {{ is_countable($wishlistProducts) ? count($wishlistProducts) : 0 }} 
    {{ (is_countable($wishlistProducts) && count($wishlistProducts) === 1) ? 'item' : 'items' }}
</p>

@if (isset($wishlistProducts) && count($wishlistProducts) > 0)
    <div class="wishlist-container">
        <div class="wishlist-grid">
            @foreach ($wishlistProducts as $item)
                <div class="card wishlist-card border-0 shadow-sm p-3">
                    <img src="{{ asset('images/category/' . $item->image) }}"
                         class="card-img-top wishlist-img mx-auto d-block"
                         alt="{{ $item->name }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $item->name }}</h5>
                        <p class="card-text text-danger fw-bold">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/customer/product/' . $item->id) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            <a href="{{ url('/customer/cart') }}" class="btn btn-success btn-sm">Add to Cart</a>
                            <form method="POST" action="{{ url('/wishlist/remove') }}" onsubmit="return confirm('Are you sure you want to remove this item from your wishlist?');">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove from Wishlist">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@else
    <div class="empty-wishlist-container">
        <i class="fas fa-heart empty-wishlist-icon mb-3"></i>
        <h4 class="empty-wishlist-text">Your wishlist is empty😢</h4>
        <p class="text-muted mb-3">Save your favorite items here for later</p>
        <a href="{{ route('catalog') }}" class="btn btn-primary px-4">Browse Products</a>
    </div>
@endif
@endsection
