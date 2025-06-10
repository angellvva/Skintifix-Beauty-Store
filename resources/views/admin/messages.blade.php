@extends('layouts.admin')

@section('content')
    <style>
        .table-responsive table {
            width: 100%;
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }

        .table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
        }

        .btn-reset,
        .btn-reset:hover {
            border: 1px solid #dee2e6;
            color: black;
            background-color: white;
            white-space: nowrap;
            width: auto;
            padding: 0.375rem 0.75rem;
        }

        .btn-search,
        .btn-search:hover {
            border: 1px solid #dee2e6;
            color: white;
            background-color: #e965a7;
        }

        .table th:not(.no-wrap),
        .table td:not(.no-wrap) {
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }
    </style>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Messages</h2>
                <p class="text-muted m-0">Display messages received from customers</p>
            </div>
        </div>

        {{-- Top Summary --}}
        <div class="row mb-4">
            <div class="col-12 col-md-3">
                <div class="card gradient-pink text-white rounded-4 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase fw-semibold mb-1">Total Messages</h6>
                            <h2 class="fw-bold mb-0">{{ $totalMessages }}</h2>
                        </div>
                        <div class="icon-circle flex-shrink-0 ms-3">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Messages Table --}}
        <div class="card">
            <div class="card-body">
                {{-- Search Form --}}
                <form method="GET" id="filterForm">
                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search messages or username..." value="{{ request('search') }}" />
                                <button type="submit" class="btn btn-search" title="Search Filter">Search</button>
                            </div>
                        </div>

                        <div class="col-md-1 d-flex align-items-end">
                            <a href="{{ url()->current() }}" class="btn btn-reset w-100 text-center">
                                <i class="bi bi-arrow-clockwise"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>


                <div class= "table-responsive">
                    <table class="table align-middle">
                        <thead class="table">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th class="no-wrap">Message</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $msg)
                                <tr>
                                    <td class="fw-bold">{{ $msg->name }}</td>
                                    <td>{{ $msg->email }}</td>
                                    <td class="no-wrap" style="white-space: normal;">{{ $msg->message }}</td>
                                    <td>{{ \Carbon\Carbon::parse($msg->created_at)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($messages->isEmpty())
                    <p class="text-muted text-center">No messages found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection



@push('styles')
    <style>
        .gradient-pink {
            background: linear-gradient(135deg, #e965a7, #ffb3d6);
        }

        .icon-circle {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            padding: 15px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }

        .btn-pink {
            background-color: #e965a7;
            color: white;
        }

        .btn-pink:hover {
            background-color: #da5195;
            color: white;
        }
    </style>
@endpush
