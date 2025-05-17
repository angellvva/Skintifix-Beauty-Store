@extends('base.base')

@section('content')
    <style>
        .section {
            background-color: #fff0f6;
        }

        .nav-tabs .nav-link.active {
            background-color: #e965a7;
            color: white;
        }

        .tab-content>.tab-pane {
            display: none;
        }

        .tab-content>.tab-pane.active {
            display: block;
        }
    </style>

    <div class="section">
        <div class="container py-5">
            <h2 class="fw-bold mb-4" style="color: #e965a7;">Edit Profile</h2>

            @if (session('success'))
                <div class="alert alert-success" style="border-color: #e965a7;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" id="profileTab">
                <li class="nav-item">
                    <a class="nav-link active" href="#" onclick="switchTab('profile')">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="switchTab('security')">Security & Privacy</a>
                </li>
            </ul>

            <!-- Content -->
            <div class="tab-content">
                <!-- Profile Tab -->
                <div class="tab-pane active" id="tab-profile">
                    <div class="h-100 card p-4"
                        style="border: 0; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h4 class="fw-bold mb-1">Personal Information</h4>
                        <p class="text-muted mb-4">Update your personal details</p>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            <!-- Profile Picture Placeholder -->
                            <div class="d-flex justify-content-center mb-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 160px; height: 160px; background-color: #fff0f6; color: #e965a7; font-size: 64px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
                                    @error('address')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror                            </div>

                            <button type="submit" class="btn mt-4" style="background-color: #e965a7; color: white;">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Security & Privacy Tab -->
                <div class="tab-pane" id="tab-security">
                    <div class="h-100 card p-4"
                        style="border: 0; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h4 class="fw-bold mb-1">Change Password</h4>
                        <p class="text-muted mb-4">Update your password to keep your account secure</p>

                        <form method="POST" action="{{ route('profile.updatePassword') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control">
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control">
                                @error('new_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn mt-4" style="background-color: #e965a7; color: white;">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Toggle active class on tabs
            const links = document.querySelectorAll('#profileTab .nav-link');
            links.forEach(link => link.classList.remove('active'));

            if (tab === 'profile') {
                links[0].classList.add('active');
                document.getElementById('tab-profile').classList.add('active');
                document.getElementById('tab-security').classList.remove('active');
            } else {
                links[1].classList.add('active');
                document.getElementById('tab-security').classList.add('active');
                document.getElementById('tab-profile').classList.remove('active');
            }
        }
    </script>
@endsection

{{-- div col lg-8 --}}
<!-- Profile Picture -->
{{-- <div class="col-lg-4">
                    <div class="h-100 card p-4 text-center"
                        style="border: 0; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <h4 class="fw-bold mb-1">Profile Picture</h4>
                        <p class="text-muted mb-4">Update your profile picture</p>

                        <div class="mb-4">
                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center"
                                style="width: 160px; height: 160px; background-color:#fff0f6;">
                                <i class="fas fa-user" style="font-size: 64px; color:#e965a7;"></i>
                            </div>
                        </div>

                        <button class="btn btn-warning text-white w-100 mb-2">
                            <i class="bi bi-upload me-1"></i> Unggah Foto Baru
                        </button>
                        <button class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-1"></i> Hapus Foto
                        </button>
                    </div>
                </div> --}}
