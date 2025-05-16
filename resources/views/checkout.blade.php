@extends('base.base')

@section('content')
<div class="container my-5">
    <div class="white-container p-4" style="border-radius: 16px;">
        <h2 class="mb-4" style="color: #e75480;">Checkout</h2>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <!-- Customer Info -->
            <h5 class="fw-bold" style="color: #e75480;">Customer Information</h5>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" 
                value="{{ $user->name ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control"
                value="{{ $user->phone ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Address</label>
                <textarea name="address" class="form-control" rows="2" required>{{ $user->address ?? '' }}</textarea>
            </div>

            <!-- Additional Address -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Postal Code</label>
                    <input type="text" name="postal_code" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Region/Province</label>
                    <input type="text" name="region" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
            </div>

            <!-- Shipping Method -->
            <h5 class="fw-bold mt-4" style="color: #e75480;">Shipping Method</h5>
            <div class="mb-3">
                <select name="shipping_method" class="form-select" required>
                    <option value="">Select a shipping method</option>
                    <option value="standard">Standard (3–5 days) - Rp20.000</option>
                    <option value="express">Express (1–2 days) - Rp40.000</option>
                </select>
            </div>

            <!-- Payment Method -->
            <h5 class="fw-bold mt-4" style="color: #e75480;">Payment Method</h5>
            <div class="mb-3">
                <select name="payment_method" class="form-select" required>
                    <option value="">Choose a payment method</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="e_wallet">E-Wallet</option>
                    <option value="credit_card">Credit Card</option>
                </select>
            </div>

            <!-- Order Summary -->
            <div class="mt-4 p-3 rounded" style="background-color: #fff5f9; border: 1px solid #f8bbd0;">
                <h5 class="mb-3" style="color: #e75480;">Order Summary</h5>
                @foreach ($cartItems as $item)
                    <div>{{ $item->name }} - Qty: {{ $item->quantity }} - Price: {{ $item->price }}</div>
                @endforeach
                <p>Total Price: <strong>Rp{{ number_format($cartTotal, 0, ',', '.') }}</strong></p>
            </div>

            <!-- Checkout Button -->
            <div class="text-center mt-4">
                <button type="submit" class="btn px-5 py-2" style="background-color: #e965a7; color: white; border-radius: 20px;">
                    Proceed to Payment
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label {
        color: #d6336c;
        font-weight: 600;
    }
</style>
@endsection
