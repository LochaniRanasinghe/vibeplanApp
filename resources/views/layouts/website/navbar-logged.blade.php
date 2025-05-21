@auth
    @if (auth()->user()->role === 'customer')
        <nav
            style="background-color: #6a1d61; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 20px;">
                {{-- Logo --}}
                <a href="/" class="d-flex align-items-center">
                    <img src="{{ asset('images/vibe-plan-logo3.png') }}" alt="Vibe Plan Logo"
                        style="width: 120px; height: auto;">
                </a>

                {{-- Welcome --}}
                <div style="font-weight: bold; font-size: 20px; font-family: 'Dancing Script', cursive; color: white;">
                    Welcome, {{ auth()->user()->name }}
                </div>
            </div>


            <div style="display: flex; gap: 20px; align-items: center;">

                {{-- Event Requests --}}
                <a href="{{ route('customer.event-requests.index') }}"
                    style="color: white; text-decoration: none; 
                    {{ request()->routeIs('customer.event-requests.index') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    My Events
                </a>
                

                {{-- Book an Event --}}
                @php
                    $showBookTab = request()->routeIs('customer.event-request.show', 'customer.event-request.create');
                @endphp

                @if ($showBookTab)
                    <a href="{{ route('dashboard') }}"
                        style="color: white; text-decoration: none; 
                            {{ $showBookTab ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                        Request Events
                    </a>
                @endif


                <a href="{{ route('customer.book-events') }}"
                    style="color: white; text-decoration: none; 
                            {{ request()->routeIs('dashboard') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    Book Events
                </a>

                {{-- Customer Dashboard --}}
                <a href="{{ route('customer.dashboard') }}"
                    style="color: white; text-decoration: none; 
                 {{ request()->routeIs('customer.dashboard') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    My Profile
                </a>

                {{-- Logout --}}
                <a href="{{ route('logout') }}"
                    style="color: white; text-decoration: none; {{ request()->routeIs('login') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    Logout
                </a>

                <a href="{{ route('customer.dashboard') }}">
                    <img src="{{ auth()->user()->profile_image
                        ? asset('storage/' . auth()->user()->profile_image)
                        : asset('images/customer-img.jpg') }}"
                        alt="Profile"
                        style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                </a>
                

            </div>
        </nav>
    @endif
@endauth
