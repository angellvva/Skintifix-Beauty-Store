<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .brand-name {
            color: #e965a7;
            font-weight: bold;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu {
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .nav-link {
            color: #333;
            font-weight: 500;
        }

        .nav-link:hover {
            color: #e965a7;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #e965a7;
        }

        .icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <header class="sticky-top border-bottom shadow-sm">
        <div class="bg-white">
            <div class="container">
                <!-- Navigation Bar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                    <div class="container-fluid">
                        <!-- Brand -->
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <span class="brand-name">Skintifix</span>
                            <span>Beauty Store</span>
                        </a>

                        <!-- Toggle Button for Mobile -->
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarContent">
                            <i class="fas fa-bars"></i>
                        </button>

                        <!-- Navigation Links -->
                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-0 gap-lg-4">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                                </li>

                                <!-- Products Dropdown -->
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown">
                                        Products
                                    </a>
                                    <ul class="dropdown-menu">
                                        {{-- nanti diubah pake foreach dari category database --}}
                                        @foreach ($categories as $category)
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('category.catalog', ['category' => $category->name]) }}">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item fw-semibold" href="{{ route('catalog') }}">View All
                                                Products</a></li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('best-seller') }}">Best Seller</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('new-arrival') }}">New Arrival</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                                </li>
                            </ul>

                            <!-- Right Icons -->
                            <div class="d-flex align-items-center">
                                <!-- Search bar -->
                                <form id="searchForm" class="position-relative d-flex align-items-center me-3 border rounded px-2"
                                    style="height: 40px;">
                                    <i class="fas fa-search me-2 text-muted"></i>
                                    <input type="text" id="searchInput" class="form-control border-0 p-0"
                                        placeholder="Search products..." autocomplete="off"
                                        style="box-shadow: none; font-size: 14px; width: 180px;" />
                                    <div id="searchResults"
                                        class="position-absolute bg-white w-100 shadow-sm mt-2 rounded"
                                        style="top: 100%; left: 0; z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                                    </div>
                                </form>

                                <a href="{{ route('cart.view') }}" class="icon-btn"
                                    style="text-decoration: none; color: #e965a7;">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>

                                <a href="{{ route('wishlist.view') }}" class="icon-btn"
                                    style="text-decoration: none; color: #e965a7;">
                                    <i class="fas fa-heart"></i>
                                </a>

                                {{-- <a href="#" class="icon-btn" style="text-decoration: none; color: #e965a7;">
                                    <i class="fas fa-user"></i>
                                </a> --}}

                                @if (session()->has('id'))
                                    <div class="dropdown">
                                        <button class="icon-btn dropdown-toggle" type="button" id="dropdownUser"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="text-decoration: none; border: none; color: #e965a7; background: transparent;">
                                            <i class="fas fa-user"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm"
                                            aria-labelledby="dropdownUser">
                                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit
                                                    Profile</a></li>
                                            <li><a class="dropdown-item" href={{ route('my-orders') }}>My Orders
                                                </a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form method="GET" action="{{ route('login') }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="dropdown-item text-danger">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="icon-btn"
                                        style="text-decoration: none; color: #e965a7;">
                                        <i class="fas fa-user"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#searchInput').on('input', function () {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: "{{ route('search.products') }}",
                method: "GET",
                data: { q: query },
                success: function (data) {
                    let results = $('#searchResults');
                    results.empty();
                    if (data.length) {
                        data.forEach(item => {
                            results.append(`
                                <a href="/product/${item.id}" class="d-block text-decoration-none px-3 py-2 border-bottom text-dark search-item">
                                    <div class="fw-bold" style="color: #e965a7;">${item.name}</div>
                                    <div style="font-size: 13px;" class="text-muted">${item.category}</div>
                                    <div style="font-size: 12px;" class="text-secondary">${item.description}</div>
                                </a>
                            `);
                        });
                        results.show();
                    } else {
                        results.html('<div class="px-3 py-2 text-muted">No results found</div>').show();
                    }
                }
            });
        } else {
            $('#searchResults').hide();
        }
    });

    // Hide dropdown on outside click
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#searchForm').length) {
            $('#searchResults').hide();
        }
    });
</script>
</body>

</html>
