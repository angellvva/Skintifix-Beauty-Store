<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="stylesheet" href="{{ asset('admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-dark border-right" id="sidebar-wrapper">
            <div class="sidebar-heading text-white fw-bold py-4 px-3">Skintifix Beauty Store</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-dark text-white">Dashboard</a>
                <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action bg-dark text-white">Products</a>
                <a href="{{ route('admin.orders') }}" class="list-group-item list-group-item-action bg-dark text-white">Orders</a>
                <a href="{{ route('admin.contacts') }}" class="list-group-item list-group-item-action bg-dark text-white">Contacts</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-3 px-3">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper" class="w-100 p-4">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
