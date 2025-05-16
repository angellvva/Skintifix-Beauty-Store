@extends('base.base')

@section('content')
<div class="container mt-5 white-container" style="background-color: white; border: 1px solid pink; padding: 30px; border-radius: 16px;">
    <h2 class="mb-4" style="color: #e75480;">Write a Review for "{{ $product->name }}"</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviews.store', $product->id) }}" method="POST">
        @csrf

        <!-- Rating -->
        <div class="mb-3">
            <label for="rating" class="form-label fw-bold">Rating (1–5):</label><br>
            @for ($i = 1; $i <= 5; $i++)
                <label style="color: #e965a7; font-size: 22px;">
                    <input type="radio" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                    ★
                </label>
            @endfor
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="content" class="form-label fw-bold">Your Review:</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content') }}</textarea>
        </div>

        <button type="submit" class="btn" style="background-color: #e965a7; color: white;">Submit Review</button>
        <a href="{{ route('product.detail', $product->id) }}" class="btn btn-secondary ms-2">Back</a>
    </form>
</div>
@endsection
