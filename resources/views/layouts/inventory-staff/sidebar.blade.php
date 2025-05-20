<style>
    .nav-pills .nav-link.active {
        background-color: #df44dc !important;
        color: #fff !important;
    }
</style>

<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <img src="{{ asset('images/vibe-plan-logo.png') }}" alt="Vibe Plan Logo" width="100%" class="me-2">
    </a>

    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('inventory_staff.dashboard') }}"
                class="nav-link {{ request()->routeIs('inventory_staff.dashboard') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('inventory_staff.inventory-items.index') }}"
                class="nav-link {{ request()->routeIs('inventory_staff.inventory-items.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#grid"></use>
                </svg>
                Inventory Items
            </a>
        </li>
        <li>
            <a href="{{ route('inventory_staff.inventory-orders.index') }}"
                class="nav-link {{ request()->routeIs('inventory_staff.inventory-orders.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#grid"></use>
                </svg>
                Inventory Orders
            </a>
        </li>
        <li>
            <a href="{{ route('inventory_staff.users.index') }}"
                class="nav-link {{ request()->routeIs('inventory_staff.users.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#grid"></use>
                </svg>
                My Profile
            </a>
        </li>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/supplier-img.jpg') }}" alt="" width="32" height="32"
                class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/logout">Sign out</a></li>
        </ul>
    </div>
</div>
