@extends('base.base') <!-- atau sesuai layout kamu -->

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid">
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p><strong>Price:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Description:</strong> {{ $product->description }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>

            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" style="display:inline-block; margin-left:10px;">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Add to Wishlist</button>
            </form>
        </div>
    </div>
</div>
@endsection