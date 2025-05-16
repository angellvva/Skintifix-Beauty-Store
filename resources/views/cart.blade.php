@extends ('base.base')
<style>
    .product-section {
        background-color: #fff0f6;
    }
</style>
@section('content')
    <div class="product-section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">Your Shopping Cart</h2>

            @if (session('success'))
                <div id="cart-notification" class="alert alert-success"
                    style="
                position: fixed;
                top: 120px;
                right: 313px;
                background-color: #d4edda;  /* hijau muda */
                color: #155724;             /* hijau gelap */
                border: 1px solid #c3e6cb; /* border hijau */
                border-radius: 8px;
                padding: 10px 20px 10px 15px;
                z-index: 9999;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                opacity: 1;
                display: flex;
                align-items: center;
                justify-content: space-between;
                min-width: 250px;
            ">
                    <span>{{ session('success') }}</span>
                    <button id="close-notification"
                        style="
                    background: transparent;
                    border: none;
                    color: #155724;
                    font-weight: bold;
                    font-size: 20px;
                    line-height: 1;
                    cursor: pointer;
                    padding: 0 5px;
                    margin-left: 15px;
                "
                        aria-label="Close notification">&times;</button>
                </div>
            @endif

            @if (isset($cartItems) && $cartItems->count() > 0)
                <div class="table-responsive shadow-sm border rounded">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr style="text-align: center;">
                                <th style="text-align:start;" scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col" style="width: 120px;">Amount</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" style="width: 100px;">Action</th>
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
                                                <h5 class="mb-1 fw-semibold" style="color: #e965a7;">{{ $item->name }}
                                                </h5>
                                                <small class="text-muted">{{ $item->description ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.update', $item->cart_id) }}" method="POST"
                                            class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                min="1" class="form-control form-control-sm" style="max-width: 60px;"
                                                onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="align-middle text-center fw-semibold">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</td>
                                    <td class="align-middle text-center">
                                        <form action="{{ route('cart.remove', $item->cart_id) }}" method="POST"
                                            class="m-0" style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to remove this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Hapus produk">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-end pe-3">
                                        <span class="fw-bold me-2" style="color: #e965a7;">Total:</span>
                                        <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('catalog') }}" class="btn btn-outline-secondary rounded-pill px-4 shadow-sm"
                        style="border-color: #e965a7; color: #e965a7; background-color: white;">
                        &lsaquo; Continue Shopping
                    </a>
                    <a href="{{ route('checkout') }}" class="btn rounded-pill px-4 shadow-sm"
                        style="background-color: #e965a7; color: #fff;">
                        Checkout
                    </a>
                </div>
            @else
                <div class="alert alert-info text-center" role="alert" style="border: 1px solid #e965a7; color: #e965a7;">
                    Keranjang belanja Anda kosong.
                </div>
                <div class="text-center">
                    <a href="{{ route('catalog') }}" class="btn rounded-pill px-4"
                        style="background-color: #e965a7; color: #fff;">
                        Kembali ke Katalog
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const notification = document.getElementById('cart-notification');
            const closeBtn = document.getElementById('close-notification');
            if (!notification) return;

            const displayTime = 2000; // waktu tampil sebelum fade out otomatis
            const fadeDuration = 500; // durasi fade out

            // Fungsi fade out dan sembunyikan elemen
            function fadeOutAndHide() {
                notification.style.transition = `opacity ${fadeDuration}ms ease`;
                notification.style.opacity = 0;
                setTimeout(() => {
                    notification.style.display = 'none';
                }, fadeDuration);
            }

            // Auto fade out setelah waktu tampil
            const timeoutId = setTimeout(fadeOutAndHide, displayTime);

            // Jika user klik tombol close, hentikan timeout dan fade out segera
            if (closeBtn) {
                closeBtn.addEventListener('click', () => {
                    clearTimeout(timeoutId);
                    fadeOutAndHide();
                });
            }
        });
    </script>

@endsection
