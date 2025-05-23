@extends('base.base')

@section('content')
<style>
    .order-detail-section {
        background-color: #fff0f6;
    }

    .order-detail-card {
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
        background-color: white;
        width: 100%;
        position: relative;
    }

    .back-icon {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 2;
        border: 1px solid #e965a7;
        color: #e965a7;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .back-icon:hover {
        background-color: #e965a7;
        color: white;
    }

    .order-product-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-bottom: 30px;
    }

    .order-product-item {
        display: flex;
        gap: 20px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
    }

    .order-product-item img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        border-radius: 12px;
    }

    .order-product-item-details {
        flex: 1;
    }

    .order-product-item-details p {
        margin: 5px 0;
    }

    .fas.fa-star {
        color: #ddd;
    }

    .fas.fa-star.active {
        color: #ffc107;
    }

    .order-summary {
        display: flex;
        flex-wrap: wrap;
        gap: 40px;
        justify-content: space-between;
    }

    .order-summary .summary-block {
        flex: 1;
        min-width: 200px;
    }

    .order-summary .summary-block p {
        margin: 4px 0;
    }

    .order-total {
        font-size: 18px;
        margin-bottom: 12px;
        text-align: right;
    }
</style>

<div class="order-detail-section">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0" style="color: #e965a7;">Order Detail 
                <span style="color: #000;">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h2>
        </div>
        <div class="order-detail-card">
            <a href="{{ route('my-orders') }}" class="btn btn-light back-icon">
                <i class="fas fa-arrow-left"></i>
            </a>

            {{-- Product List --}}
            <div class="order-product-list">
                @foreach ($order->orderItems as $orderItem)
                <div class="order-product-item">
                    <img src="{{ $orderItem->product->image }}" alt="{{ $orderItem->product->name }}">
                    <div class="order-product-item-details">
                        <h4 class="mb-1">{{ $orderItem->product->name }}</h4>
                        <p><strong>Qty:</strong> {{ $orderItem->quantity }}</p>
                        <p><strong>Price:</strong> Rp{{ number_format($orderItem->price, 0, ',', '.') }}</p>
                        <div>
                            <i class="fas fa-star active"></i>
                            <i class="fas fa-star active"></i>
                            <i class="fas fa-star active"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="order-total">
                Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }} <br>
                Shipping Cost: Rp{{ number_format($order->shipping_price, 0, ',', '.') }}<br>
                <strong>Total Amount: Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
            </div>
            
            <br>

            {{-- Summary --}}
            <div class="order-summary">
                <div class="summary-block">
                    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <br>
                    <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</p>
                    <p><strong>Estimated Delivery:</strong> {{ \Carbon\Carbon::parse($order->orderItems[0]->estimated_delivery)->format('d M Y') }}</p>
                    <p><strong>Shipping Date:</strong> {{ \Carbon\Carbon::parse($order->orderItems[0]->shipping_date)->format('d M Y') }}</p>
                    <br>
                    <p><strong>Address:</strong></p>
                    <p>{{ $order->user->address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
