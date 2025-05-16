@extends('base.base')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4" style="color: #e965a7;">Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success" style="border-color: #e965a7;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" class="border p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" value="{{ $user->address }}">
        </div>

        <button type="submit" class="btn" style="background-color: #e965a7; color: white;">Save Changes</button>
    </form>
</div>
@endsection
