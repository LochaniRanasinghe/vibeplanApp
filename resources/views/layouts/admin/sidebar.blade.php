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
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.index') }}"
                class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Manage Users
            </a>
        </li>
        <li>
            <a href="{{ route('admin.event-types.index') }}"
                class="nav-link {{ request()->routeIs('admin.event-types.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#home"></use>
                </svg>
                Event Types
            </a>
        </li>
        <li>
            <a href="{{ route('admin.event-requests.index') }}"
                class="nav-link {{ request()->routeIs('admin.event-requests.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#table"></use>
                </svg>
                Requested Events
            </a>
        </li>
        <li>
            <a href="{{ route('admin.custom-events.index') }}"
                class="nav-link {{ request()->routeIs('admin.custom-events.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#table"></use>
                </svg>
                Sheduled Events
            </a>
        </li>
        <li>
            <a href="{{ route('admin.inventory-items.index') }}"
                class="nav-link {{ request()->routeIs('admin.inventory-items.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#grid"></use>
                </svg>
                Inventory Items
            </a>
        </li>
        <li>
            <a href="{{ route('admin.inventory-orders.index') }}"
                class="nav-link {{ request()->routeIs('admin.inventory-orders.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#grid"></use>
                </svg>
                Inventory Orders
            </a>
        </li>
        <li>
            <a href="{{ route('admin.payments.index') }}"
                class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : 'link-dark' }}">
                <svg class="bi me-2" width="16" height="16">
                    <use xlink:href="#people-circle"></use>
                </svg>
                Event Payments
            </a>
        </li>
    </ul>

    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
            id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('images/admin-img.png') }}" alt="" width="32" height="32"
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
