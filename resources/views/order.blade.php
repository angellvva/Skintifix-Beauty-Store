@extends('base.base')

@section('content')
    <style>
        .order-section {
            background-color: #fff0f6;
        }

        .order-img {
            width: 100%;
            border: 1px solid #dee2e6;
        }

        .btn-pink {
            color: #e965a7;
            background-color: white;
            border: 1px solid #e965a7;
        }

        .btn-pink:hover {
            color: white;
            background-color: #e965a7;
        }

        .btn-pink2 {
            color: white;
            background-color: #e965a7;
        }

        .btn-pink2:hover {
            color: white;
            background-color: #da5195;
        }

        .btn-search,
        .btn-search:hover {
            border: 1px solid #dee2e6;
            color: white;
            background-color: #e965a7;
        }

        .btn-reset,
        .btn-reset:hover {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
        }
    </style>

    <div class="order-section">
        <div class="container py-5">
            <div class="row g-3">
                <div class="col-md-7">
                    <h2 class="fw-bold mb-4" style="color: #e965a7;">My Order</h2>
                </div>
                <div class="col-md-4">
                    <form id="filterForm" method="GET" action="{{ url()->current() }}">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control"
                                placeholder="Search order ID or product name..." aria-label="Search"
                                aria-describedby="basic-addon1" value="{{ request('search') }}" />
                            <button type="submit" class="btn btn-search" title="Search Filter">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-1">
                    <a href="{{ url()->current() }}" class="btn btn-reset" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>

            @if (isset($orders) && count($orders) > 0)
                @foreach ($orders as $order)
                    <div class="p-4"
                        style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: {{ $loop->last ? '0' : '20px' }};">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-normal">Order ID:
                                                <b
                                                    style="color:#e965a7;">SKINTIFIX-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</b></span>
                                            <span @class([
                                                'badge rounded-pill border px-3 py-1',
                                                'border-secondary text-secondary' => $order->status == 'pending',
                                                'border-warning text-warning' => $order->status == 'processing',
                                                'border-success text-success' => $order->status == 'completed',
                                            ])>
                                                {{ ucfirst($order->status) }}
                                            </span>

                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalOrderPrice = 0;
                                @endphp

                                @foreach ($orderItemsGrouped[$order->id] ?? [] as $item)
                                    @php
                                        $subtotal = $item->price * $item->quantity;
                                        $totalOrderPrice += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                                        class="order-img">
                                                </div>
                                                <div class="col-md-9 p-0">
                                                    <p class="fw-bold mb-1">{{ $item->name }}</p>
                                                    <p class="mb-0">Amount: {{ $item->quantity }}</p>
                                                </div>
                                                <div class="col-md-2" style="text-align: right;">
                                                    Rp{{ number_format($subtotal, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row align-items-center">
                            <div class="col-md-10 text-end">
                                Total Amount:
                            </div>
                            <div class="col-md-2" style="text-align: right; color:#e965a7;">
                                <h4 class="m-0">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <a href="{{ route('order.show', ['order_id' => $order->id]) }}"
                                class="btn btn-sm btn-pink">Order
                                Detail</a>
                            <a href="{{ route('catalog') }}" class="btn btn-sm btn-pink2">Buy
                                again
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="background-color: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div class="table-responsive text-center py-5">
                        <i class="fas fa-shopping-bag fa-4x mb-4" style="color: #e965a7;"></i>
                        <h4 class="mb-3" style="color: #e965a7;">Your order is empty.</h4>
                        <p class="text-muted mb-4">Looks like you haven't checked out yet.</p>
                        <a href="{{ route('catalog') }}" class="btn rounded-pill px-4 shadow-sm"
                            style="background-color: #e965a7; color: white;">
                            Checkout Now
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
