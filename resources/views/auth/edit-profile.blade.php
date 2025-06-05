@extends('base.base')

@section('content')
    <style>
        .section {
            background-color: #fff0f6;
        }

        .section h2 {
            color: #e965a7;
            font-weight: bold;
            text-align: center;
            margin-bottom: 40px;
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
            <h2>Edit Profile</h2>

            @if (session('success'))
                <div id="notification" class="alert alert-success"
                    style="position: fixed; top: 120px; right: 313px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px; padding: 10px 20px 10px 15px; z-index: 9999; box-shadow: 0 2px 8px rgba(0,0,0,0.1); opacity: 1; display: flex; align-items: center; justify-content: space-between; min-width: 250px;">
                    <span>{{ session('success') }}</span>
                    <button id="close-notification"
                        style="background: transparent; border: none; color: #155724; font-weight: bold; font-size: 20px; line-height: 1; cursor: pointer; padding: 0 5px; margin-left: 15px;"
                        aria-label="Close notification">&times;</button>
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
                            <div class="d-flex justify-content-center mb-4">
                                <div class="rounded-circle d-flex justify-content-center align-items-center"
                                    style="width: 160px; height: 160px; background-color: #fff0f6; color: #e965a7; font-size: 64px;">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', Auth::user()->name) }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Phone Number</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', Auth::user()->phone) }}">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control"
                                    value="{{ old('address', Auth::user()->address) }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

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
                                @error('new_password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
        document.addEventListener('DOMContentLoaded', function() {
            const savedTab = localStorage.getItem('activeTab') || 'profile';
            switchTab(savedTab);
        });

        function switchTab(tab) {
            // Toggle active class on tabs
            const links = document.querySelectorAll('#profileTab .nav-link');
            links.forEach(link => link.classList.remove('active'));

            // Hide all panes
            document.getElementById('tab-profile').classList.remove('active');
            document.getElementById('tab-security').classList.remove('active');

            // Show selected tab and save to localStorage
            if (tab === 'profile') {
                links[0].classList.add('active');
                document.getElementById('tab-profile').classList.add('active');
            } else {
                links[1].classList.add('active');
                document.getElementById('tab-security').classList.add('active');
            }

            localStorage.setItem('activeTab', tab);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTab = localStorage.getItem('activeTab') || 'profile';
            switchTab(savedTab);

            // Auto-dismiss success notification after 5 seconds
            const notification = document.getElementById('notification');
            if (notification) {
                setTimeout(() => {
                    notification.style.transition = 'opacity 0.5s ease';
                    notification.style.opacity = 0;
                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endsection
