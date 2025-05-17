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

                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
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
                    <h5 class="fw-bold mt-4" style="color: #e75480;">
                        <i class="fas fa-truck me-2"></i>Shipping Method
                    </h5>
                    <div class="mb-3">
                        <select name="shipping_method" class="form-select" required>
                            <option value="">Select a shipping method</option>
                            <option value="standard" data-cost="20000">Standard (3–5 days) - Rp20.000</option>
                            <option value="express" data-cost="40000">Express (1–2 days) - Rp40.000</option>
                        </select>
                    </div>

                    <!-- Payment Method -->
                    <h5 class="fw-bold mt-4" style="color: #e75480;">
                        <i class="fas fa-wallet me-2"></i>Payment Method
                    </h5>
                    <div class="mb-4">
                        <select name="payment_method" class="form-select" required>
                            <option value="">Choose a payment method</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="e_wallet">E-Wallet</option>
                            <option value="credit_card">Credit Card</option>
                        </select>
                    </div>
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
                    
                    @foreach ($cartItems as $item)
                        <input type="hidden" name="selected_items[]" value="{{ $item->cart_id }}">
                    @endforeach
                    <button type="button" id="pay-button" class="btn w-100 rounded-pill shadow-sm"
                        style="background-color: #e965a7; color: white;">
                        <i class="fas fa-lock me-2"></i>Proceed to Payment
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
```

</div>

<!-- Existing shipping update script -->

<script>
    const shippingSelect = document.querySelector('select[name="shipping_method"]');
    const shippingCostElem = document.querySelector('#shipping-cost');
    const totalCostElem = document.querySelector('#total-cost');

    function parseRp(rpString) {
        return parseInt(rpString.replace(/[Rp.\s]/g, '')) || 0;
    }

    function formatRp(num) {
        return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    const subtotal = parseRp(document.querySelector('#subtotal').textContent);

    shippingSelect.addEventListener('change', function () {
        const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
        const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
        shippingCostElem.textContent = formatRp(shippingCost);
        totalCostElem.textContent = formatRp(subtotal + shippingCost);
    });
</script>

<!-- Midtrans Snap.js -->

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<!-- Handle Pay Button Click & Call Snap -->

<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        let formData = new FormData(document.getElementById('checkout-form'));

        fetch("{{ route('checkout.process') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (!data.snap_token) {
                alert('Invalid Snap Token. Please try again.');
                return;
            }

            snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    alert("Payment success!");
                    window.location.href = "/order-success"; 
                },
                onPending: function(result) {
                    alert("Waiting for payment...");
                },
                onError: function(result) {
                    alert("Payment failed: " + result.message);
                },
                onClose: function() {
                    alert('You closed the payment popup without finishing the payment');
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment initiation failed, please try again.');
        });
    });
</script>

<!-- Midtrans Snap.js (use sandbox for testing) -->

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

@endsection
