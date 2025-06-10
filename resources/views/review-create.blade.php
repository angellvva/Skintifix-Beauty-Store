@extends('base.base')

@section('content')

<div style="background-color: #fff0f6; padding: 60px 0;">
    <div class="container" style="max-width: 750px; background-color: white; border: 1px solid #f8bbd0; padding: 40px 30px; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.05);">

        <h2 class="text-center mb-3" style="color: #e75480; font-weight: bold;">Write a Review for "{{ $product->name }}"</h2>
        <p class="text-center mb-4" style="color: #888;">We'd love to hear what you think about this product!</p>

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

            <!-- Star Rating -->
            <div class="mb-4 text-center">
                <label class="form-label fw-bold d-block" style="color: #e75480;">Your Rating:</label>
                <div id="starRating" style="font-size: 30px; color: #e965a7; cursor: pointer;">
                    @for ($i = 1; $i <= 5; $i++)
                        <i id="star-{{ $i }}" class="far fa-star"
                           onclick="setRating({{ $i }})"
                           onmouseover="hoverRating({{ $i }})"
                           onmouseout="resetStars()"></i>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 0) }}">
            </div>

            <!-- Review Text -->
            <div class="mb-4">
                <label for="comment" class="form-label fw-bold" style="color: #e75480;">Your Review:</label>
                <textarea name="comment" class="form-control" rows="4">{{ old('comment') }}</textarea>
            </div>

            <!-- Buttons -->
            <div class="text-center">
                <button type="submit" class="btn px-4 py-2" style="background-color: #e965a7; color: white; border-radius: 8px;">Submit Review</button>
                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-secondary ms-2">Back</a>
            </div>
        </form>
    </div>
</div>

<script>
    let selectedRating = parseInt(document.getElementById('ratingInput').value) || 0;

    function setRating(rating) {
        selectedRating = rating;
        document.getElementById('ratingInput').value = rating;
        updateStars(rating);
    }

    function hoverRating(rating) {
        updateStars(rating);
    }

    function resetStars() {
        updateStars(selectedRating);
    }

    function updateStars(rating) {
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + i);
            star.className = i <= rating ? 'fas fa-star' : 'far fa-star';
        }
    }

    // Restore old rating on load
    window.onload = function () {
        updateStars(selectedRating);
    };
</script>

@endsection
