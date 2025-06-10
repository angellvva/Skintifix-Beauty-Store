<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .brand-name {
            color: #e965a7;
            font-weight: bold;
        }

        @media (min-width: 992px) {
            .dropdown:hover .dropdown-menu {
                display: block;
            }
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

        /* Default icon button styling for desktop (40x40) */
        .icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        /* Default search input group styling for desktop (180px width, 40px height) */
        #searchForm.input-group {
            width: 180px; /* Keep original size for desktop */
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            height: 40px;
            flex-shrink: 0;
        }

        #searchForm .form-control {
            border: none;
            box-shadow: none;
            padding: 0.375rem 0.75rem;
            font-size: 14px;
        }

        #searchForm .input-group-text {
            background-color: transparent;
            border: none;
            color: #6c757d;
            padding-right: 0;
            padding-left: 0.75rem;
        }

        .spinner-border.text-pink {
            color: #e965a7 !important;
        }

        /* Mobile specific styles */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                overflow-x: hidden;
            }

            /* Container for search form and icons */
            .navbar-collapse .d-flex.align-items-center {
                width: 100%;
                justify-content: space-between !important;
                margin-top: 15px;
                padding: 0 15px; /* Add some horizontal padding */
                box-sizing: border-box; /* Include padding in width calculation */
            }

            #searchForm {
                /* Allow search form to be flexible but prioritize space for icons */
                flex-grow: 1;
                /* Calculate max-width: Total available width - (3 * 40px for icons) - (2 * 5px for icon margins) - (margin between search and icons) - (overall padding) */
                /* For a 320px wide screen (common minimum), after 30px padding, 290px remain.
                   3 icons = 120px, margins = 10px. So 130px for icons.
                   290px - 130px = 160px for search bar.
                   So, max-width needs to be adaptable. Let's use flex-basis to suggest a size. */
                flex-basis: 150px; /* Suggest a minimum flexible width */
                max-width: calc(100% - (3 * 40px) - (2 * 5px) - 8px); /* max-width = total width - icon space - icon margins - search-icon margin */
                min-width: 120px; /* Ensure it doesn't get too small */
                margin-right: 8px; /* Reduced space between search and icons */
            }

            #searchForm .form-control {
                font-size: 13px; /* Slightly smaller font for input text */
            }

            #searchForm .input-group-text {
                padding-left: 0.5rem;
            }

            /* Group of Icons for better control */
            .icon-buttons-group {
                display: flex;
                align-items: center;
                /* flex-shrink: 0; /* Prevent icons from shrinking if they must be 40x40 */
            }

            /* Icons are now strictly 40x40 on mobile as requested */
            .icon-btn {
                width: 40px; /* Fixed width */
                height: 40px; /* Fixed height */
                font-size: 1.2rem; /* Keep icon font size appropriate for 40x40 */
                margin-left: 5px; /* Small margin between icons */
                flex-shrink: 0; /* Important: Prevent icons from shrinking */
            }

            .icon-btn:first-child {
                margin-left: 0;
            }

            /* Specific adjustment for the user dropdown button padding, as it might have default padding */
            .dropdown .icon-btn {
                padding: 0; /* Remove default button padding */
            }
        }
    </style>
</head>

<body>
    <header class="sticky-top border-bottom shadow-sm">
        <div class="bg-white">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <span class="brand-name">Skintifix</span>
                            <span>Beauty Store</span>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarContent">
                            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-0 gap-lg-4">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                                </li>

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

                            <div class="d-flex align-items-center w-100 w-lg-auto mt-3 mt-lg-0">
                                <form id="searchForm" class="input-group position-relative me-3">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Search products..." autocomplete="off" />
                                    <div id="searchResults"
                                        class="position-absolute bg-white w-100 shadow-sm mt-2 rounded"
                                        style="top: 100%; left: 0; z-index: 1000; display: none; max-height: 300px; overflow-y: auto;">
                                    </div>
                                </form>

                                <div class="d-flex align-items-center icon-buttons-group">
                                    <a href="{{ route('cart.view') }}" class="icon-btn"
                                        style="text-decoration: none; color: #e965a7;">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>

                                    <a href="{{ route('wishlist.view') }}" class="icon-btn"
                                        style="text-decoration: none; color: #e965a7;">
                                        <i class="fas fa-heart"></i>
                                    </a>

                                    @auth
                                        <div class="dropdown">
                                            <button class="icon-btn dropdown-toggle" type="button" id="dropdownUser"
                                                data-bs-toggle="dropdown" aria-expanded="false"
                                                style="text-decoration: none; border: none; color: #e965a7; background: transparent; padding: 0;">
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
                                                    <form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}" class="icon-btn"
                                            style="text-decoration: none; color: #e965a7;">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const dropdown = document.getElementById('searchResults');

            searchInput.addEventListener('input', function() {
                const query = this.value.trim();
                if (query.length > 1) {
                    dropdown.innerHTML = `
                        <div class="d-flex justify-content-center align-items-center p-3">
                            <div class="spinner-border text-pink" style="width: 1.5rem; height: 1.5rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `;
                    dropdown.style.display = 'block';
                    fetch(`/search/products?q=${encodeURIComponent(query)}`)
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
                                    <img src="${product.image}" alt="${product.name}" style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px;">
                                    <div>
                                        <div class="fw-medium" style="color: #e965a7; font-size: 13px;">${product.name}</div>
                                        <div class="text-muted" style="font-size: 12px;">${product.category}</div>
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

            document.addEventListener('click', function(e) {
                const form = document.getElementById('searchForm');
                if (!form.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>