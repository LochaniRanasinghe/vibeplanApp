{{-- @auth
    @if (auth()->user()->role === 'customer')
        <nav
            style="background-color: rgb(105, 68, 41); color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="/" class="d-flex align-items-center">
                    <img src="{{ asset('images/vibe-plan-logo3.png') }}" alt="Vibe Plan Logo"
                        style="width: 120px; height: auto;">
                </a>

                <div style="font-weight: bold; font-size: 20px; font-family: 'Dancing Script', cursive; color: white;">
                    Welcome, {{ auth()->user()->name }}
                </div>
            </div>


            <div style="display: flex; gap: 20px; align-items: center;">
                <a href="{{ route('customer.event-requests.index') }}"
                    style="color: white; text-decoration: none; 
                    {{ request()->routeIs('customer.event-requests.index') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    My Events
                </a>
                

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

                <a href="{{ route('customer.dashboard') }}"
                    style="color: white; text-decoration: none; 
                 {{ request()->routeIs('customer.dashboard') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
                    My Profile
                </a>

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
@endauth --}}
<nav id="customer-navbar" class="position-relative"
    style="background-color:#300628; padding: 15px 40px; overflow: hidden;">
    <!-- Canvas Background -->
    <canvas id="customerNavbarCanvas"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></canvas>

    <div class="position-relative w-100 d-flex justify-content-between align-items-center"
        style="z-index: 2; color: white;">
        {{-- Left: Logo and Welcome --}}
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="font-weight: bold; font-size: 20px; font-family: 'Dancing Script', cursive;">
                VibePlan - Welcome, {{ auth()->user()->name }}
            </div>
        </div>

        {{-- Right: Menu --}}
        <div style="display: flex; gap: 20px; align-items: center;">
            <a href="{{ route('customer.event-requests.index') }}"
                class="nav-link-animated {{ request()->routeIs('customer.event-requests.index') ? 'active' : '' }}">
                My Events
            </a>

            @php
                $showBookTab = request()->routeIs('customer.event-request.show', 'customer.event-request.create');
            @endphp

            @if ($showBookTab)
                <a href="{{ route('dashboard') }}" class="nav-link-animated {{ $showBookTab ? 'active' : '' }}">
                    Request Events
                </a>
            @endif

            <a href="{{ route('customer.book-events') }}"
                class="nav-link-animated {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Book Events
            </a>

            <a href="{{ route('customer.dashboard') }}"
                class="nav-link-animated {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                My Profile
            </a>

            <a href="{{ route('logout') }}" class="nav-link-animated">
                Logout
            </a>

            <a href="{{ route('customer.dashboard') }}">
                <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/customer-img.jpg') }}"
                    alt="Profile"
                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
            </a>
        </div>
    </div>
</nav>
<style>
    .nav-link-animated {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link-animated:hover {
        color: #ffca28;
        transform: translateY(-2px);
    }

    .nav-link-animated.active {
        font-weight: bold;
        border-bottom: 2px solid white;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('customerNavbarCanvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = 80;
        }

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const blobs = Array.from({
            length: 12
        }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 25 + 10,
            dx: (Math.random() - 0.5) * 1.2,
            dy: (Math.random() - 0.5) * 1.2,
            color: `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, 200, 0.2)`
        }));

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            blobs.forEach(blob => {
                ctx.beginPath();
                ctx.arc(blob.x, blob.y, blob.r, 0, Math.PI * 2);
                ctx.fillStyle = blob.color;
                ctx.fill();
                blob.x += blob.dx;
                blob.y += blob.dy;

                if (blob.x + blob.r > canvas.width || blob.x - blob.r < 0) blob.dx *= -1;
                if (blob.y + blob.r > canvas.height || blob.y - blob.r < 0) blob.dy *= -1;
            });
            requestAnimationFrame(animate);
        }

        animate();
    });
</script>
