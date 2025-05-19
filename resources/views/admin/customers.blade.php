@extends('layouts.admin')

@section('content')
    <style>
        .btn-prev-next {
            color: white;
            background-color: #e965a7;
        }

        .btn-prev-next:hover {
            color: white;
            background-color: #da5195;
        }

        table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        tbody td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #dee2e6;
        }

        .table th,
        .table td {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            white-space: nowrap;
            width: auto;
            padding: 0.375rem 0.75rem;
        }
    </style>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Customers</h2>
                <p class="text-muted m-0">Monitor your customers effectively to boost satisfaction and increase sales</p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form id="filterForm" method="GET" action="{{ url()->current() }}">
                    <div class="row g-2 g-md-3 mb-3 align-items-center">
                        <div class="col-12 col-md-5">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search customer name..." aria-label="Search"
                                    aria-describedby="basic-addon1" value="{{ request('search') }}" />
                            </div>
                        </div>
                        <div class="col-12 col-md-3">
                            <select name="status" class="form-select"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="highest_spend" {{ request('status') == 'highest_spend' ? 'selected' : '' }}>
                                    Highest
                                    Spend</option>
                                <option value="most_orders" {{ request('status') == 'most_orders' ? 'selected' : '' }}>Most
                                    Orders
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2">
                            <a href="{{ url()->current() }}" class="btn btn-reset " title="Reset Filter">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Orders</th>
                            <th>Total Spent</th>
                            <th>Last Order</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td class="fw-bold">{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->orders->count() }}</td>
                                <td>Rp {{ number_format($customer->orders->sum('total_amount'), 0, ',', '.') }}</td>
                                <td>
                                    {{ $customer->orders->sortByDesc('created_at')->first()->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($customers->isEmpty())
                    <p class="text-muted text-center">No customers found.</p>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if ($customers->total() == 0)
                            Showing 0 entries
                        @else
                            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of
                            {{ $customers->total() }}
                            entries
                        @endif
                    </div>

                    {{-- Pagination links --}}
                    <div class="d-flex justify-content-end">
                        @if ($customers->onFirstPage())
                            <button class="btn btn-secondary me-1" disabled>Prev</button>
                        @else
                            <a href="{{ $customers->previousPageUrl() }}" class="btn btn-prev-next me-1"
                                style="margin-right: 4px;">Prev</a>
                        @endif

                        @if ($customers->hasMorePages())
                            <a href="{{ $customers->nextPageUrl() }}" class="btn btn-prev-next ms-1">Next</a>
                        @else
                            <button class="btn btn-secondary ms-1" disabled>Next</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endsection
