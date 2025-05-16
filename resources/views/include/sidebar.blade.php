<!-- SIDEBAR CSS -->
<style>
    .sidebar {
        width: 300px;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        z-index: 1000;
        background: linear-gradient(180deg, #e965a7, #eaa5c8);
        padding-top: 20px;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s;
    }

    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.75);
        margin: 4px 0;
        font-weight: 500;
        display: flex;
        align-items: center;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        color: #fff;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 0;
        font-weight: 600;
        box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.05);
    }

    .sidebar .nav-link i {
        margin-right: 12px;
        font-size: 1.2rem;
    }

    .sidebar .logo img {
        width: 40px;
        margin-right: 10px;
    }

    .sidebar .logo span {
        font-size: 1.3rem;
        color: #ffffff;
        letter-spacing: 0.5px;
    }

    .sidebar .sign-out {
        padding-left: 24px;
    }

    .sidebar .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
        font-weight: 500;
        transition: 0.2s ease;
        border-radius: 8px;
    }

    .sidebar .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .logout-btn {
        font-size: 0.85rem;
        padding: 6px 10px;
        border-radius: 6px;
        transition: 0.2s ease;
        color: #dc3545;
        border: 1px solid #dc3545;
        background-color: transparent;
    }

    .logout-btn:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .gray-text {
        color: gray;
    }

    .shadow-top {
        box-shadow: 0 -4px 6px -2px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- SIDEBAR HTML -->
<div class="sidebar">
    <div class="justify-content-start align-items-center mb-2 px-3 logo">
        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none align-items-center">
            <span><b>Skintifix</b> Beauty Mart</span>
        </a>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-house"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.products') }}"
                class="nav-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-cart3"></i> Orders
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Customers
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-tag"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-boxes"></i> Inventory
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-gift"></i> Promotions
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders') }}"
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-line"></i> Analytics
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.contacts') }}"
                class="nav-link {{ request()->routeIs('admin.contacts') ? 'active' : '' }}">
                <i class="bi bi-phone"></i> Contacts
            </a>
        </li>
    </ul>

    <div class="position-absolute bottom-0 start-0 w-100 px-3 shadow-top" style="background-color: white;">
        <form action="{{ route('logout') }}" method="POST" class="w-100">
            @csrf
            <div class="d-flex align-items-center justify-content-between m-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person fs-4 text-secondary" style="margin-right: 12px;"></i>
                    <div>
                        <div class="fw-bold">Admin User</div>
                        <div class="text-muted small">admin@skintifix.com</div>
                    </div>
                </div>

                <button type="submit" class="btn p-0">
                    <i class="bi bi-box-arrow-right p-0"></i>
                </button>
            </div>
        </form>
    </div>
</div>
