<nav class="navbar navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Brand -->
        <a class="navbar-brand ms-3">Event Organizer Workspace</a>

        <!-- Search Form -->
        <form class="d-flex" onsubmit="return false;">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-secondary" type="submit">
                <i class="mdi mdi-magnify"></i>
            </button>
        </form>

        <!-- Profile Picture -->
        <div class="dropdown me-5">
            <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('images/admin-img2.jpg') }}" alt="" width="50" height="50"
                    class="rounded-circle me-2">
                <strong>Profile</strong>
            </a>
            <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="/logout">Sign out</a></li>
            </ul>
        </div>

    </div>
</nav>
