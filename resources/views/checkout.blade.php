@extends('base.base')

@section('content')
    <div class="checkout-section">
        <div class="container py-5">
            <h2>Checkout</h2>
            <div class="row g-4">
                {{-- LEFT: Checkout Form --}}
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST" novalidate>
                            @csrf

                            <!-- Recipient Info -->
                            <h5 class="card-title fw-bold mb-3" style="color: #e965a7;">
                                <i class="fas fa-user me-2"></i>Recipient Information
                            </h5>

                            <div class="mb-4">
                                <button type="button" id="toggle-default"
                                    class="btn btn-outline-pink rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i>Use my account information
                                </button>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name ?? '' }}" required>
                                <div class="invalid-feedback">Full Name is required.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="recipient_phone" id="phone" class="form-control"
                                    value="{{ $user->phone ?? '' }}" required>
                                <div class="invalid-feedback">Phone Number is required.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Full Address</label>
                                <textarea name="address" id="address" class="form-control" rows="2" required>{{ $user->address ?? '' }}</textarea>
                                <div class="invalid-feedback">Full Address is required.</div>
                            </div>

                            <!-- Shipping Method -->
                            <h5 class="card-title fw-bold mb-3" style="color: #e965a7;">
                                <i class="fas fa-truck me-2"></i>Shipping Method
                            </h5>

                            <div class="mb-3">
                                <select name="shipping_method" id="shipping-method-select" class="form-select" required>
                                    <option value="" disabled selected hidden>Select a shipping method</option>
                                    <option value="standard" data-cost="20000" selected>Standard (3 days) - Rp20.000
                                    </option>
                                    <option value="express" data-cost="40000">Express (1 day) - Rp40.000</option>
                                </select>
                                <div class="invalid-feedback">Please select a shipping method.</div>
                            </div>

                            @foreach ($cartItems as $item)
                                <input type="hidden" name="selected_items[]" value="{{ $item->cart_id }}">
                            @endforeach

                            <!-- Hidden input for shipping cost and total amount -->
                            <input type="hidden" name="shipping_cost" id="shipping-cost-hidden" value="20000">
                            <input type="hidden" name="total_amount" id="total-amount-hidden"
                                value="{{ $cartItems->sum(fn($item) => $item->price * $item->quantity) + 20000 }}">
                        </form>
                    </div>
                </div>

                {{-- RIGHT: Order Summary --}}
                <div class="col-md-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold mb-3" style="color: #e965a7;">
                                <i class="fas fa-receipt me-2"></i>Order Summary
                            </h5>

                            @php
                                $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                                $shipping = 20000;
                                $total = $subtotal + $shipping;
                            @endphp

                            @forelse ($cartItems as $item)
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="d-flex">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="rounded"
                                            style="width: 60px; height: 60px; object-fit: cover; margin-right: 10px;">
                                        <div>
                                            <div class="fw-semibold" style="color: #e965a7;">{{ $item->name }}</div>
                                            <div class="text-muted small">{{ $item->quantity }} ×
                                                Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-semibold">
                                        Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                                </div>
                                <hr>
                            @empty
                                <p class="text-muted">Your cart is empty.</p>
                            @endforelse

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

                            <button type="submit" form="checkout-form" class="btn w-100 rounded-pill shadow-sm"
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
        const shippingSelect = document.getElementById('shipping-method-select');
        const shippingCostElem = document.getElementById('shipping-cost');
        const totalCostElem = document.getElementById('total-cost');
        const hiddenShippingCost = document.getElementById('shipping-cost-hidden');
        const hiddenTotalAmount = document.getElementById('total-amount-hidden');

        function formatRp(num) {
            return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        shippingSelect.addEventListener('change', function() {
            const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;
            const subtotal = parseInt(document.getElementById('subtotal').textContent.replace(/[Rp.\s]/g, '')) || 0;
            const total = subtotal + shippingCost;

            shippingCostElem.textContent = formatRp(shippingCost);
            totalCostElem.textContent = formatRp(total);
            hiddenShippingCost.value = shippingCost;
            hiddenTotalAmount.value = total;
        });

        // Toggle account info button
        const toggleBtn = document.getElementById('toggle-default');
        const defaultName = @json($user->name ?? '');
        const defaultPhone = @json($user->phone ?? '');
        const defaultAddress = @json($user->address ?? '');

        function toggleRecipientFields(disabled) {
            ['name', 'phone', 'address'].forEach(id => {
                document.getElementById(id).readOnly = disabled;
            });
        }

        let useDefault = true;

        toggleBtn.addEventListener('click', function() {
            useDefault = !useDefault;
            this.classList.toggle('active', useDefault);

            const icon = this.querySelector('i');

            if (useDefault) {
                document.getElementById('name').value = defaultName;
                document.getElementById('phone').value = defaultPhone;
                document.getElementById('address').value = defaultAddress;
            } else {
                document.getElementById('name').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('address').value = '';

                icon.classList.remove('fas');
                icon.classList.add('far');
            }

            toggleRecipientFields(useDefault);
        });

        toggleBtn.classList.add('active');
        toggleRecipientFields(true);

        document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const address = document.getElementById('address').value.trim();
        const shipping = document.getElementById('shipping-method-select').value;

        if (!name || !phone || !address || !shipping) {
            e.preventDefault();
            showFormAlert();
        }
    });

    function showFormAlert() {
        const alertBox = document.getElementById('form-alert');
        alertBox.style.display = 'block';
        setTimeout(() => {
            alertBox.style.opacity = '1';
        }, 10);
        setTimeout(() => {
            hideFormAlert();
        }, 5000);
    }

    function hideFormAlert() {
        const alertBox = document.getElementById('form-alert');
        alertBox.style.opacity = '0';
        setTimeout(() => {
            alertBox.style.display = 'none';
        }, 400);
    }

    </script>

    <style>
        .checkout-section {
            background-color: #fff0f6;
        }

        .checkout-section h2 {
            color: #e965a7;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
        }

        .btn-outline-pink {
            color: #e965a7;
            border: 2px solid #e965a7;
            background-color: transparent;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-outline-pink.active {
            background-color: #e965a7;
            color: white;
            border: 2px solid #e965a7;
        }

        .btn-outline-pink i {
            transition: transform 0.3s;
        }

        .btn-outline-pink.active i {
            transform: rotate(360deg);
        }
    </style>

    <!-- Floating toast for incompleted form -->
    <div id="form-alert" class="position-fixed" style="
        top: 120px;
        right: 105px;
        z-index: 9999;
        background-color: #f8d7da;
        color: #721c24;
        border: 1 px solid #f5c6cb;
        border-radius: 8px;
        padding: 10px 20px 10px 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        opacity: 0; 
        display: none; 
        transition: opacity 0.5s ease; 
        min-width: 250px; 
        display: flex; 
        align-items: center;
    ">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-start">
                <div>
                    <strong style="color: #721c24;">Incomplete Form</strong>
                    <p class="mb-0" style="font-size: 14px; color: #721c24;">
                        Please fill in all the required fields before proceeding to payment.
                    </p>
                </div>
            </div>
            <button onclick="hideFormAlert()" style="background: none; border: none; font-size: 20px; color: #721c24;">×</button>
        </div>
    </div>

@endsection
