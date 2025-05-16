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

        .btn-reset {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            width: 100%;
            box-sizing: border-box;
        }
    </style>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Customers</h2>
                <p class="text-muted">View customer information and interactions</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-white border border-pink text-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Total Customers</div>
                        <h3 class="mb-0">{{ number_format($totalCustomers) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white border border-pink text-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">New Customers</div>
                        <h3 class="mb-0">+{{ $newCustomers }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white border border-pink text-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Repeat Customers</div>
                        <h3 class="mb-0">{{ $repeatCustomers }}%</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-white border border-pink text-pink shadow-sm">
                    <div class="card-body">
                        <div class="small">Avg. Order Value</div>
                        <h3 class ="mb-0">Rp{{ number_format($avgOrderValue, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Form -->
        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search customers..."
                            value="{{ request('search') }}" />
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="all" {{ request('type', 'all') == 'all' ? 'selected' : '' }}>All Customers</option>
                        <option value="new" {{ request('type') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="repeat" {{ request('type') == 'repeat' ? 'selected' : '' }}>Repeat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Most Recent</option>
                        <option value="orders" {{ request('sort') == 'orders' ? 'selected' : '' }}>Most Orders</option>
                        <option value="spent" {{ request('sort') == 'spent' ? 'selected' : '' }}>Highest Spent</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="{{ url()->current() }}" class="btn btn-reset" title="Reset Filter">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Customer Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
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
                    @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->orders_count }}</td>
                        <td>Rp{{ number_format($customer->total_spent, 0, ',', '.') }}</td>
                        <td>{{ $customer->last_order ? \Carbon\Carbon::parse($customer->last_order)->format('M d, Y') : 'Never' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No customers found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end">
                {{ $customers->withQueryString()->links() }}
            </div>
        </div>

        <form id="filterForm" method="GET" action="{{ url()->current() }}">
            <div class="row g-3 mb-3 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" placeholder="Search customers..."
                            aria-label="Search" aria-describedby="basic-addon1" value="{{ request('search') }}" />
                    </div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                        <option value="highest_spend" {{ request('status') == 'highest_spend' ? 'selected' : '' }}>Highest
                            Spend</option>
                        <option value="most_orders" {{ request('status') == 'most_orders' ? 'selected' : '' }}>Most Orders
                        </option>
                    </select>
                </div>
                <div class="col-md-1">
                    <a href="{{ url()->current() }}" class="btn btn-reset" title="Reset Filter">
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

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
                @if ($customers->total() == 0)
                    Showing 0 entries
                @else
                    Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }}
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
@endsection

@push('styles')
<style>
    .text-pink {
        color: #e965a7 !important;
    }
    .border-pink {
        border-color: #e965a7 !important;
    }
</style>
@endpush