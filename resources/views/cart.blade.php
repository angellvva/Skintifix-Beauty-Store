@extends ('base.base')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #e965a7;">Your shopping cart</h2>

    @if(count($cartItems) > 0)
    <div class="table-responsive shadow-sm border rounded">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">Product</th>
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
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                <div>
                                    <h5 class="mb-1 fw-semibold" style="color: #e965a7;">{{ $item['name'] }}</h5>
                                    <small class="text-muted">{{ $item['description'] ?? '' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="align-middle">
                            <input type="number" class="form-control" value="{{ $item['quantity'] }}" min="1" style="max-width: 70px;">
                        </td>
                        <td class="align-middle fw-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="align-middle">
                            <button class="btn btn-outline-danger btn-sm" title="Hapus produk">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end fw-bold" style="color: #e965a7;">Total:</th>
                    <th class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('catalog') }}" class="btn btn-outline-secondary rounded-pill px-4" style="border-color: #e965a7; color: #e965a7;">
            &lsaquo; Continue Shopping
        </a>
        <a href="{{ route('checkout') }}" class="btn rounded-pill px-4" style="background-color: #e965a7; color: #fff;">
            Checkout
        </a>
    </div>

    @else
    <div class="alert alert-info text-center" role="alert" style="border: 1px solid #e965a7; color: #e965a7;">
        Keranjang belanja Anda kosong.
    </div>
    <div class="text-center">
        <a href="{{ route('catalog') }}" class="btn rounded-pill px-4" style="background-color: #e965a7; color: #fff;">
            Kembali ke Katalog
        </a>
    </div>
    @endif
</div>
@endsection
