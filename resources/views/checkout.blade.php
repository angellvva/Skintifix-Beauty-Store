@extends('base.base')

@section('content')

<div class="checkout-section py-5" style="background-color: #fff0f6;">
    <div class="container">
        <div class="row g-4">
            {{-- LEFT: Checkout Form --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="mb-4 fw-bold" style="color: #e75480;">
                        <i class="fas fa-credit-card me-2"></i>Checkout
                    </h2>

                    <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST" novalidate>
                        @csrf

                        <!-- Customer Info -->
                        <h5 class="fw-bold mb-3" style="color: #e75480;">
                            <i class="fas fa-user me-2"></i>Customer Information
                        </h5>

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" 
                                value="{{ $user->name ?? '' }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ $user->phone ?? '' }}" required>
                            <div class="invalid-feedback">Phone Number is required.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" id="address" class="form-control" rows="2" required>{{ $user->address ?? '' }}</textarea>
                            <div class="invalid-feedback">Full Address is required.</div>
                        </div>

                        <!-- Additional Address -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" id="postal_code" class="form-control" required>
                                <div class="invalid-feedback">Postal Code is required.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Region/Province</label>
                                <input type="text" name="region" id="region" class="form-control" required>
                                <div class="invalid-feedback">Region/Province is required.</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" id="country" class="form-control" required>
                                <div class="invalid-feedback">Country is required.</div>
                            </div>
                        </div>

                        <!-- Shipping Method -->
                        <h5 class="fw-bold mt-4" style="color: #e75480;">
                            <i class="fas fa-truck me-2"></i>Shipping Method
                        </h5>
                        <div class="mb-3">
                            <select name="shipping_method" id="shipping-method-select" class="form-select" required>
                                <option value="">Select a shipping method</option>
                                <option value="standard" data-cost="20000">Standard (3–5 days) - Rp20.000</option>
                                <option value="express" data-cost="40000">Express (1–2 days) - Rp40.000</option>
                            </select>
                            <div class="invalid-feedback">Please select a shipping method.</div>
                        </div>

                        <!-- Payment Method -->
                        <h5 class="fw-bold mt-4" style="color: #e75480;">
                            <i class="fas fa-wallet me-2"></i>Payment Method
                        </h5>
                        <div class="mb-4">
                            <select name="payment_method" id="payment-method" class="form-select" required>
                                <option value="">Choose a payment method</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="e_wallet">E-Wallet</option>
                                <option value="credit_card">Credit Card</option>
                            </select>
                            <div class="invalid-feedback">Please select a payment method.</div>
                        </div>

                        @foreach ($cartItems as $item)
                            <input type="hidden" name="selected_items[]" value="{{ $item->cart_id }}">
                        @endforeach
                    </form>
                </div>
            </div>

            {{-- RIGHT: Order Summary --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-4" style="color: #e965a7;">
                            <i class="fas fa-receipt me-2"></i>Order Summary
                        </h5>

                        @forelse ($cartItems as $item)
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex">
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="rounded"
                                         style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                    <div>
                                        <div class="fw-semibold" style="color: #e965a7;">{{ $item->name }}</div>
                                        <div class="text-muted small">{{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="fw-semibold">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                            </div>
                            <hr>
                        @empty
                            <p class="text-muted">Your cart is empty.</p>
                        @endforelse

                        @php
                            $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                            $shipping = 20000; // flat rate shipping
                            $total = $subtotal + $shipping;
                        @endphp

                        <div class="d-flex justify-content-between mt-3">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <span id="shipping-cost">Rp{{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5 mb-4">
                            <span>Total</span>
                            <span id="total-cost">Rp{{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <button type="button" id="pay-button" class="btn w-100 rounded-pill shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            <i class="fas fa-lock me-2"></i>Proceed to Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update shipping cost and total on shipping method change
    const shippingSelect = document.getElementById('shipping-method-select');
    const shippingCostElem = document.getElementById('shipping-cost');
    const totalCostElem = document.getElementById('total-cost');

    function formatRp(num) {
        return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    shippingSelect.addEventListener('change', function () {
        const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
        const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
        shippingCostElem.textContent = formatRp(shippingCost);

        const subtotal = parseInt(document.getElementById('subtotal').textContent.replace(/[Rp.\s]/g, '')) || 0;
        totalCostElem.textContent = formatRp(subtotal + shippingCost);
    });

    // Validate before proceeding to payment with inline error messages
    document.getElementById('pay-button').addEventListener('click', function () {
        const form = document.getElementById('checkout-form');
        const fields = [
            'phone',
            'address',
            'postal_code',
            'region',
            'country',
            'shipping-method-select',
            'payment-method'
        ];

        let formValid = true;

        fields.forEach(id => {
            const el = document.getElementById(id);
            if (!el.value.trim()) {
                el.classList.add('is-invalid');
                formValid = false;
            } else {
                el.classList.remove('is-invalid');
            }
        });

        if (formValid) {
            form.submit();
        }
    });
</script>

@endsection
