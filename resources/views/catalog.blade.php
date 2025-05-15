@extends ('base.base')

@section('content')
<div class="bg-pink-50 min-h-screen py-10">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold text-pink-600 mb-8 text-center">All Products</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($products as $product)
            <div class="bg-white border border-pink-200 rounded-2xl p-4 shadow-lg hover:shadow-pink-300 transition-all duration-300">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg mb-3">
                <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                <p class="text-sm text-gray-500 mb-1">Stock: {{ $product->stock }}</p>
                <p class="text-pink-600 font-bold text-base">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 60) }}</p>

                <div class="flex justify-between items-center mt-4">
                    {{-- Add to Cart --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-pink-500 hover:text-pink-700 transition">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                        </button>
                    </form>

                    {{-- Add to Wishlist --}}
                    <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-pink-500 hover:text-pink-700 transition">
                            <i class="fas fa-heart fa-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="col-span-4 text-center text-gray-400">No products found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
