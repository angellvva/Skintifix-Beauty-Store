@extends('base.base')
@section('content')

    <style>
        .product-section {
            background-color: #fff0f6;
        }

        .product-section h2 {
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

        @media (max-width: 768px) {
            .table-responsive-mobile {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            table {
                min-width: 600px;
            }

            .product-section h2 {
                font-size: 20px;
            }

            .btn-outline-pink span {
                font-size: 14px;
            }

            .form-control-sm {
                font-size: 14px;
            }

            .btn {
                font-size: 14px;
            }
        }
    </style>

    <div class="product-section">
        <div class="container py-5">
            <h2>Your Shopping Cart</h2>

            {{-- Floating toast for unselected checkout --}}
            <div id="select-item-toast" class="alert alert-danger"
                style="position: fixed; top: 120px; right: 105px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 20px 10px 15px; z-index: 9999; box-shadow: 0 2px 8px rgba(0,0,0,0.1); opacity: 0; display: none; transition: opacity 0.5s ease; min-width: 250px; display: flex; align-items: center; justify-content: space-between;">
                <span>Please select at least one item to checkout.</span>
                <button id="close-toast"
                    style="background: transparent; border: none; color: #721c24; font-weight: bold; font-size: 20px; line-height: 1; cursor: pointer; padding: 0 5px; margin-left: 15px;"
                    aria-label="Close toast">&times;</button>
            </div>

            @if (isset($cartItems) && $cartItems->count() > 0)
                <div class="table-responsive-mobile">
                    <table class="table align-middle mb-0 shadow-sm border rounded">
                        <thead class="table-light">
                            <tr style="text-align: center;">
                                <th style="text-align:start;" scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col" style="width: 140px;">Amount</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" style="width: 100px;">Action</th>
                                <th scope="col" style="width: 100px;">Checkout</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cartItems as $item)
                                @php
                                    $subtotal = $item->product->price * $item->quantity;
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td style="max-width: 600px; white-space: normal;">
                                        <div class="d-flex align-items-center gap-3" style="margin-right: 10px;">
                                            <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                                class="rounded"
                                                style="width: 80px; height: 80px; object-fit: cover; margin-left: 10px;">
                                            <div>
                                                <h5 class="mb-1 fw-semibold" style="color: #e965a7;">
                                                    {{ $item->product->name }}
                                                </h5>
                                                <small class="text-muted">{{ $item->product->description ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center price">Rp
                                        {{ number_format($item->product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{-- Form update quantity --}}
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            class="form-control form-control-sm quantity-input"
                                            data-cart-id="{{ $item->id }}"
                                            style="max-width: 70px; display:inline-block;">
                                    </td>
                                    <td class="align-middle text-center fw-semibold subtotal">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="align-middle text-center">
                                        {{-- Form hapus item --}}
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to remove this item?');"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Hapus produk">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle text-center">
                                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" checked>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="d-flex justify-content-end pe-3">
                                        <span class="fw-bold me-2" style="color: #e965a7;">Total:</span>
                                        <span class="fw-bold" id="total-display">Rp
                                            {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Form checkout terpisah --}}
                <form id="checkout-form" action="{{ route('checkout') }}" method="GET" class="mt-4">
                    @csrf
                    {{-- Kirim hanya selected_items --}}
                    {{-- Gunakan checkbox yang dipilih --}}
                    <input type="hidden" name="selected_items" id="selected-items-input" value="">

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="button" id="toggle-checkboxes"
                                class="btn btn-outline-pink rounded-pill px-4 shadow-sm">
                                <i class="far fa-circle me-2"></i><span>Select All Items</span>
                            </button>
                        </div>
                        <button type="submit" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: #fff;">
                            Checkout
                        </button>
                    </div>
                </form>
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your cart is empty.</h4>
                        <p class="text-muted mb-4">Looks like you haven’t added anything to your cart yet.</p>
                        <a href="{{ route('catalog') }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Browse Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                const cartId = this.dataset.cartId;
                const newQty = this.value;

                fetch(`/cart/update/${cartId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: newQty
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                        location.reload();
                    })
                    .catch(error => {
                        console.error('Update error:', error);
                    });
            });
        });
    </script>

    <script>
        // Close select item toast
        document.getElementById('close-toast')?.addEventListener('click', () => {
            const toast = document.getElementById('select-item-toast');
            if (toast) {
                toast.style.transition = 'opacity 0.5s ease';
                toast.style.opacity = 0;
                setTimeout(() => toast.style.display = 'none', 500);
            }
        });

        // Saat submit form checkout, ambil semua checkbox yang dipilih dan simpan di hidden input
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');
            if (checkboxes.length === 0) {
                e.preventDefault();
                const toast = document.getElementById('select-item-toast');
                if (!toast) return;
                toast.style.display = 'flex';
                setTimeout(() => {
                    toast.style.opacity = 1;
                }, 10);
                setTimeout(() => {
                    toast.style.opacity = 0;
                    setTimeout(() => {
                        toast.style.display = 'none';
                    }, 500);
                }, 2500);
                return false;
            }

            // Buat array dari nilai cart_id yang dicentang
            const selectedIds = Array.from(checkboxes).map(cb => cb.value);
            // Simpan sebagai string dipisah koma di hidden input
            document.getElementById('selected-items-input').value = selectedIds.join(',');
        });
    </script>

    <script>
        // Format angka ke Rupiah
        function formatRp(num) {
            return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Update subtotal dan total otomatis saat quantity berubah
        function updateTotals() {
            let total = 0;

            document.querySelectorAll('tbody tr').forEach(row => {
                const checkbox = row.querySelector('input[type="checkbox"]');
                const priceEl = row.querySelector('.price');
                const qtyInput = row.querySelector('input[name="quantity"]');
                const subtotalEl = row.querySelector('.subtotal');

                if (!priceEl || !qtyInput || !subtotalEl || !checkbox) return;

                // Ambil harga dan quantity
                let price = parseInt(priceEl.textContent.replace(/[^0-9]/g, '')) || 0;
                let qty = parseInt(qtyInput.value) || 0;

                // Hitung subtotal baris
                let subtotal = price * qty;
                subtotalEl.textContent = formatRp(subtotal);

                if (checkbox.checked) {
                    total += subtotal;
                }
            });

            document.getElementById('total-display').textContent = formatRp(total);
        }

        // Pasang event listener pada semua input quantity
        document.querySelectorAll('input[name="quantity"]').forEach(input => {
            input.addEventListener('input', updateTotals);
        });

        document.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', updateTotals);
        });

        document.querySelectorAll('input[name="selected_items[]"]').forEach(cb => {
            cb.addEventListener('change', () => {
                const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);

                const icon = toggleBtn.querySelector('i');
                const label = toggleBtn.querySelector('span');

                if (allChecked) {
                    icon.className = 'fas fa-check-circle me-2';
                    label.textContent = 'Deselect All Items';
                    toggleBtn.classList.add('active');
                    allSelected = true;
                } else {
                    icon.className = 'far fa-check-circle me-2';
                    label.textContent = 'Select All Items';
                    toggleBtn.classList.remove('active');
                    allSelected = false;
                }

                updateTotals(); // pastikan total juga diperbarui
            });
        });

        // Hitung ulang saat halaman load
        window.addEventListener('load', updateTotals);

        // Checkbox toggle logic
        const toggleBtn = document.getElementById('toggle-checkboxes');
        let allSelected = Array.from(document.querySelectorAll('input[name="selected_items[]"]'))
            .every(cb => cb.checked);

        toggleBtn?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('input[name="selected_items[]"]');
            allSelected = !allSelected;

            checkboxes.forEach(cb => cb.checked = allSelected);

            const icon = toggleBtn.querySelector('i');
            const label = toggleBtn.querySelector('span');

            if (allSelected) {
                icon.className = 'fas fa-check-circle me-2';
                label.textContent = 'Deselect All Items';
                toggleBtn.classList.add('active');
            } else {
                icon.className = 'far fa-check-circle me-2';
                label.textContent = 'Select All Items';
                toggleBtn.classList.remove('active');
            }

            updateTotals();
        });
    </script>

    <script>
        const STORAGE_KEY = 'cartSelectedItems';

        function saveSelectedCheckboxes() {
            const checkedBoxes = Array.from(document.querySelectorAll('input[name="selected_items[]"]:checked'))
                .map(cb => cb.value);
            localStorage.setItem(STORAGE_KEY, JSON.stringify(checkedBoxes));
        }

        function loadSelectedCheckboxes() {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored) {
                const selectedIds = JSON.parse(stored);
                document.querySelectorAll('input[name="selected_items[]"]').forEach(cb => {
                    cb.checked = selectedIds.includes(cb.value);
                });
            } else {
                document.querySelectorAll('input[name="selected_items[]"]').forEach(cb => cb.checked = true);
            }
        }

        window.addEventListener('load', () => {
            localStorage.removeItem('cartSelectedItems');
            loadSelectedCheckboxes();
            updateTotals();

            // Reset tampilan tombol
            const icon = toggleBtn.querySelector('i');
            const label = toggleBtn.querySelector('span');
            icon.className = 'fas fa-check-circle me-2';
            label.textContent = 'Deselect All Items';
            toggleBtn.classList.add('active');
        });

        document.querySelectorAll('input[name="selected_items[]"]').forEach(cb => {
            cb.addEventListener('change', () => {
                saveSelectedCheckboxes();
                updateTotals();
            });
        });

        document.getElementById('toggle-checkboxes')?.addEventListener('click', () => {
            saveSelectedCheckboxes();
        });

        document.getElementById('checkout-form').addEventListener('submit', () => {
            saveSelectedCheckboxes();
        });
    </script>


@endsection
