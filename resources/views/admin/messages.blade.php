@extends('layouts.admin')

@section('content')
    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold" style="color: #e965a7;">Messages</h2>
                <p class="text-mute m-0">Handle communication and messages with customers and support</p>
            </div>
        </div>

        {{-- Top Summary --}}
        <div class="row mb-4">
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card gradient-pink text-white rounded-4 shadow-sm h-100">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase fw-semibold mb-1">Total Messages</h6>
                            <h3 class="fw-bold mb-0">{{ $totalMessages }}</h3>
                        </div>
                        <div class="icon-circle flex-shrink-0 ms-3">
                            <i class="fas fa-envelope fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Form --}}
        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search messages or username..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-pink" type="submit">Search</button>
                </div>
            </div>
        </form>

        {{-- Messages Table --}}
        <div class="card">
            <div class="card-body p-0">
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $msg)
                            <tr>
                                <td>{{ $msg->id }}</td>
                                <td>{{ $msg->name }}</td>
                                <td>{{ $msg->email }}</td>
                                <td>{{ Str::limit($msg->message, 50) }}</td>
                                <td>{{ \Carbon\Carbon::parse($msg->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No messages found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
