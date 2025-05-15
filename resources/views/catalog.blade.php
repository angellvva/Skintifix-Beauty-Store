@extends ('base.base')

@section('content')
<div class="container py-5">
    <h1 class="text-2xl font-bold mb-6">All Products</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
        <div class="border rounded-xl p-4 shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl bg-white flex flex-col justify-between">
            <div>
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-3 rounded">
                <h2 class="text-lg font-semibold transition-colors duration-300 hover:text-pink-600">{{ $product->name }}</h2>
                <p class="text-gray-600">Stock: {{ $product->stock }}</p>
                <p class="text-pink-600 font-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 60) }}</p>
            </div>
            <div class="mt-4 flex flex-col sm:flex-row gap-2">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-pink-500 hover:bg-pink-600 text-white font-semibold py-2 px-4 rounded transition duration-300">
                        Add to Cart
                    </button>
                </form>
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded transition duration-300">
                        ♥ Wishlist
                    </button>
                </form>
            </div>
        </div>
        @empty
        <p class="col-span-4 text-center text-gray-500">No products found.</p>
        @endforelse
    </div>
</div>
@endsection