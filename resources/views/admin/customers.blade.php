@extends('layouts.admin')

@section('content')
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