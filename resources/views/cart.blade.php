@extends('base.base')
@section('content')

    <style>
        .product-section {
            background-color: #fff0f6;
        }
    </style>

    <div class="product-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">Your Shopping Cart</h2>
            @if (session('success'))
                <div id="cart-notification" class="alert alert-success"
                    style="position: fixed; top: 120px; right: 313px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; padding: 10px 20px 10px 15px; z-index: 9999; box-shadow: 0 2px 8px rgba(0,0,0,0.1); opacity: 1; display: flex; align-items: center; justify-content: space-between; min-width: 250px;">
                    <span>{{ session('success') }}</span>
                    <button id="close-notification"
                        style="background: transparent; border: none; color: #155724; font-weight: bold; font-size: 20px; line-height: 1; cursor: pointer; padding: 0 5px; margin-left: 15px;"
                        aria-label="Close notification">&times;</button>
                </div>
            @endif

            {{-- Floating toast for unselected checkout --}}
            <div id="select-item-toast" class="alert alert-danger"
                style="position: fixed; top: 120px; right: 253px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px; padding: 10px 20px 10px 15px; z-index: 9999; box-shadow: 0 2px 8px rgba(0,0,0,0.1); opacity: 0; display: none; transition: opacity 0.5s ease; min-width: 250px; display: flex; align-items: center; justify-content: space-between;">
                <span>Please select at least one item to checkout.</span>
                <button id="close-toast"
                    style="background: transparent; border: none; color: #721c24; font-weight: bold; font-size: 20px; line-height: 1; cursor: pointer; padding: 0 5px; margin-left: 15px;"
                    aria-label="Close toast">&times;</button>
            </div>

            @if (isset($cartItems) && $cartItems->count() > 0)
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
                                $subtotal = $item->price * $item->quantity;
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td style="max-width: 600px; white-space: normal;">
                                    <div class="d-flex align-items-center gap-3" style="margin-right: 10px;">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="rounded"
                                            style="width: 80px; height: 80px; object-fit: cover; margin-left: 10px;">
                                        <div>
                                            <h5 class="mb-1 fw-semibold" style="color: #e965a7;">{{ $item->name }}</h5>
                                            <small class="text-muted">{{ $item->description ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center price">Rp {{ number_format($item->price, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-center">
                                    {{-- Form update quantity --}}                                
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" 
                                            class="form-control form-control-sm quantity-input"
                                            data-cart-id="{{ $item->cart_id }}"
                                            style="max-width: 70px; display:inline-block;">                          
                                </td>
                                <td class="align-middle text-center fw-semibold subtotal">Rp
                                    {{ number_format($subtotal, 0, ',', '.') }}</td>
                                <td class="align-middle text-center">
                                    {{-- Form hapus item --}}
                                    <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to remove this item?');"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Hapus produk">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="align-middle text-center">
                                    <input type="checkbox" name="selected_items[]" value="{{ $item->cart_id }}">
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

                {{-- Form checkout terpisah --}}
                <form id="checkout-form" action="{{ route('checkout') }}" method="POST" class="mt-4">
                    @csrf
                    {{-- Kirim hanya selected_items --}}
                    {{-- Gunakan checkbox yang dipilih --}}
                    <input type="hidden" name="selected_items" id="selected-items-input" value="">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('catalog') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm"
                            style="border-color: #e965a7; color: #e965a7; background-color: white;">
                            &lsaquo; Continue Shopping
                        </a>
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
            input.addEventListener('change', function () {
                const cartId = this.dataset.cartId;
                const newQty = this.value;

                fetch(`/cart/update-quantity/${cartId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ quantity: newQty })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                })
                .catch(error => {
                    console.error('Update error:', error);
                });
            });
        });
    </script>


    <script>
        // Close success notification
        document.getElementById('close-notification')?.addEventListener('click', () => {
            const notification = document.getElementById('cart-notification');
            if (notification) {
                notification.style.transition = 'opacity 0.5s ease';
                notification.style.opacity = 0;
                setTimeout(() => notification.style.display = 'none', 500);
            }
        });

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

                if (checkbox.checked){
                    total += subtotal;
                }
            });

            document.getElementById('total-display').textContent = formatRp(total);
        }

        // Pasang event listener pada semua input quantity
        document.querySelectorAll('input[name="quantity"]').forEach(input => {
            input.addEventListener('input', updateTotals);
        });

        document.querySelectorAll('input[type="checkbox"]').forEach(cb =>{
            cb.addEventListener('change', updateTotals);
        });

        // Hitung ulang saat halaman load
        window.addEventListener('load', updateTotals);
    </script>

@endsection
