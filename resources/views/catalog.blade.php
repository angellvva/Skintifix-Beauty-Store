@extends ('base.base')

@section('content')
<div class="container py-5">
    <h1 class="text-2xl font-bold mb-6">All Products</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($products as $product)
        <div class="border rounded-xl p-4 shadow hover:shadow-lg transition">
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-3 rounded">
            <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
            <p class="text-gray-600">Stock: {{ $product->stock }}</p>
            <p class="text-pink-600 font-bold mt-2">Rp{{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ Str::limit($product->description, 60) }}</p>
        </div>
        @empty
        <p class="col-span-4 text-center text-gray-500">No products found.</p>
        @endforelse
    </div>
</div>
@endsection