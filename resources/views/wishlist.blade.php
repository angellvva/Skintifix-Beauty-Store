@extends('base.base')

@section('content')

{{-- Sample data for wishlist --}}
{{-- In a real application, this data would be fetched from the database --}}
@php
    $wishlist = [
        [
            'id' => 1,
            'name' => 'Cleanser',
            'price' => 145000,
            'image' => 'Cleanser.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Hydrating Toner',
            'price' => 89000,
            'image' => 'Toner.jpg'
        ]
    ];
@endphp

<style>
    h2 {
        margin-left: 60px;
        margin-top: 20px;
    }
    .item-desc {
        margin-left: 60px;
    }

</style>


<h2 class="mb-2">My Wishlist</h2>
<p class="item-desc text-muted mb-4 text-start">
    You have {{ is_countable($wishlist) ? count($wishlist) : 0 }} 
    {{ (is_countable($wishlist) && count($wishlist) === 1) ? 'item' : 'items' }}
</p>


@if (isset($wishlist) && count($wishlist) > 0)
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($wishlist as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <img src="{{ asset('images/category/' . $item['image']) }}"
                         class="card-img-top mx-auto d-block" style="height: 200px; width: auto; object-fit: contain;"
                         alt="{{ $item['name'] }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p class="card-text text-danger fw-bold">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/customer/product/' . $item['id']) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            <a href="{{ url('/customer/cart') }}" class="btn btn-success btn-sm">Add to Cart</a>
                            <form method="POST" action="{{ url('/wishlist/remove/' . $item['id']) }}" onsubmit="return confirm('Are you sure you want to remove this item from your wishlist?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Remove from Wishlist">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-warning text-center" role="alert">
        Your wishlist is empty 😢
    </div>
@endif
@endsection