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

            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
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

            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .product-category-label {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: #e965a7;
            color: white;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            z-index: 10;
        }
    </style>

    <div class="product-section">
        <div class="container">
            <h1>Best Seller Products</h1>
            <div class="product-grid">
                @forelse ($order_items as $item)
                    <div class="product-card position-relative" style="cursor: pointer;"
                        onclick="window.location='{{ route('product.detail', $item->product->id) }}'">
                        <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}">

                        <!-- Label kategori -->
                        <div class="product-category-label">
                            {{ $item->product->category->name }}
                        </div>

                        <div class="product-name">{{ $item->product->name }}</div>
                        <div class="product-stock">Stock: {{ $item->product->stock }}</div>
                        <div class="product-price">Rp{{ number_format($item->product->price, 0, ',', '.') }}</div>
                        <div class="product-description">{{ $item->product->description, 60 }}</div>
                    </div>
                @empty
                    <p style="text-align: center; width: 100%; color: #888;">No products found.</p>
                @endforelse
            </div>
        </div>
    </div>
    </div>
@endsection
