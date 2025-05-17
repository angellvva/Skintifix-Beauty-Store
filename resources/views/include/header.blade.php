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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-input');
        const dropdown = document.getElementById('search-dropdown');

        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            if (query.length > 1) {
                fetch(`/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(products => {
                        dropdown.innerHTML = '';

                        if (products.length > 0) {
                            products.forEach(product => {
                                const item = document.createElement('div');
                                item.className = 'search-item d-flex align-items-center gap-3 p-2 border-bottom';
                                item.style.cursor = 'pointer';
                                item.onclick = () => {
                                    window.location.href = `/product/${product.id}`;
                                };

                                item.innerHTML = `
                                    <img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                    <div>
                                        <div class="fw-semibold" style="color: #e965a7;">${product.name}</div>
                                        <div class="text-muted" style="font-size: 13px;">${product.category}</div>
                                        <div style="font-size: 13px; color: #555;">${product.description}</div>
                                    </div>
                                `;
                                dropdown.appendChild(item);
                            });
                        } else {
                            dropdown.innerHTML = '<div class="p-2 text-muted">No products found</div>';
                        }

                        dropdown.style.display = 'block';
                    });
            } else {
                dropdown.innerHTML = '';
                dropdown.style.display = 'none';
            }
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!document.querySelector('.search-container').contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    });
</script>
</body>

</html>
