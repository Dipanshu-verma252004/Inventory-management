<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-text fw-bold fs-4">
                Inventory
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <li class="menu-item">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Masters</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('categories.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-category"></i>
                <div>Categories</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('brands.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-purchase-tag"></i>
                <div>Brands</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('units.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-ruler"></i>
                <div>Units</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('suppliers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Suppliers</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Inventory</span>
        </li>

        <li class="menu-item">
            <a href="{{ route('products.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div>Products</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
            <a href="{{ route('purchases.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div>Purchase</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Customers</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('sales.*') ? 'active' : '' }}">
            <a href="{{ route('sales.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div>Sales</div>
            </a>
        </li>

    </ul>

</aside>
