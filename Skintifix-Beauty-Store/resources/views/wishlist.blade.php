@extends('base.base')

@section('content')
<h2 class="mb-4">My Wishlist</h2>

@if (isset($wishlist) && count($wishlist) > 0)
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($wishlist as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ asset('images/products/' . $item['image']) }}" class="card-img-top" alt="{{ $item['name'] }}">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $item['name'] }}</h5>
                        <p class="card-text text-danger fw-bold">Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url('/customer/product/' . $item['id']) }}" class="btn btn-outline-secondary btn-sm">View</a>
                            <a href="{{ url('/customer/cart') }}" class="btn btn-success btn-sm">Add to Cart</a>
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