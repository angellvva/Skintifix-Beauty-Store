@extends ('base.base')

@section('content')
<style>
    .product-section {
        background-color: #fff0f6;
        padding: 50px 20px;
        min-height: 100vh;
    }

    .product-section h1 {
        color: #e965a7;
        font-weight: bold;
        text-align: center;
        margin-bottom: 40px;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
    }

    .product-card {
        background-color: #fff;
        border: 1px solid #e965a7;
        border-radius: 12px;
        width: calc(25% - 24px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        text-align: center;
    }

    .product-card:hover {
        box-shadow: 0 0 24px rgba(0, 0, 0, 0.15);
    }

    .product-card img {
        max-height: 150px;
        object-fit: contain;
        margin-bottom: 15px;
    }

    .product-name {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
        color: #333;
    }

    .product-stock {
        color: #888;
        font-size: 14px;
    }

    .product-price {
        font-size: 16px;
        color: #e965a7;
        font-weight: bold;
        margin: 10px 0;
    }

    .product-description {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .icon-btns form {
        display: inline-block;
        margin: 0 5px;
    }

    .icon-btns button {
        background: none;
        border: none;
        color: #e965a7;
        font-size: 20px;
        cursor: pointer;
    }

    .icon-btns button:hover {
        color: #c44c8f;
    }

    @media (max-width: 992px) {
        .product-card {
            width: calc(50% - 24px);
        }
    }

    @media (max-width: 576px) {
        .product-card {
            width: 100%;
        }
    }
</style>

<div class="product-section">
    <div class="container">
        <h1>Best Seller Products</h1>
        <div class="product-grid">
            @forelse ($order_items as $item)
                <div class="product-card" style="cursor: pointer;" onclick="window.location='{{ route('product.detail', $item->product->id) }}'">
                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">
                    <div class="product-name">{{ $item->product->name }}</div>
                    <div class="product-stock">Stock: {{ $item->product->stock }}</div>
                    <div class="product-price">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                    <div class="product-description">{{ Str::limit($item->product->description, 60) }}</div>
                    <div class="icon-btns">
                        <form action="{{ route('cart.add', $item->product->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="Add to Cart"><i class="fas fa-shopping-cart"></i></button>
                        </form>
                        <form action="{{ route('wishlist.add', $item->product->id) }}" method="POST">
                            @csrf
                            <button type="submit" title="Add to Wishlist"><i class="fas fa-heart"></i></button>
                        </form>
                    </div>
                </div>
            @empty
                <p style="text-align: center; width: 100%; color: #888;">No products found.</p>
            @endforelse
        </div>
    </div>
</div>
</div>
@endsection
