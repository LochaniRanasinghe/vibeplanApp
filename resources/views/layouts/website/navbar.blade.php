{{-- <nav style="background-color: #300628; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center;">
    <div style="font-weight: bold; font-size: 30px; font-family: 'Dancing Script', cursive;">VibePlan-Event Organizers</div>
    <div style="display: flex; gap: 20px;">
        <a href="{{ route('dashboard') }}" 
           style="color: white; text-decoration: none; {{ request()->routeIs('dashboard') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
            Home
        </a>
        <a href="{{ route('about') }}" 
           style="color: white; text-decoration: none; {{ request()->routeIs('about') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
            About Us
        </a>
        <a href="{{ route('news') }}" 
           style="color: white; text-decoration: none; {{ request()->routeIs('news') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
            News
        </a>
        <a href="{{ route('register') }}" 
           style="color: white; text-decoration: none; {{ request()->routeIs('register') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
            Register
        </a>
        <a href="{{ route('login') }}" 
           style="color: white; text-decoration: none; {{ request()->routeIs('login') ? 'font-weight: bold; border-bottom: 2px solid white;' : '' }}">
            Login
        </a>
    </div>
</nav> --}}
<nav id="animated-navbar" class="position-relative"
    style="background-color: #300628; color: white; padding: 15px 40px; overflow: hidden;">
    <!-- Canvas Background -->
    <canvas id="navbarCanvas"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0;"></canvas>

    <div class="position-relative w-100 d-flex justify-content-between align-items-center" style="z-index: 2;">
        <div style="font-weight: bold; font-size: 30px; font-family: 'Dancing Script', cursive;">VibePlan-Event
            Organizers</div>

        <div style="display: flex; gap: 25px;">
            @php
                $navLinks = [
                    'dashboard' => 'Home',
                    'about' => 'About Us',
                    'news' => 'News',
                    'register' => 'Register',
                    'login' => 'Login',
                ];
            @endphp

            @foreach ($navLinks as $route => $label)
                <a href="{{ route($route) }}" class="nav-link-animated {{ request()->routeIs($route) ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
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
        border-bottom: 2px solid #fff;
    }

    /* Subtle float effect */
    #animated-navbar a {
        animation: floaty 2s ease-in-out infinite;
    }

    #animated-navbar a:nth-child(2) {
        animation-delay: 0.1s;
    }

    #animated-navbar a:nth-child(3) {
        animation-delay: 0.2s;
    }

    #animated-navbar a:nth-child(4) {
        animation-delay: 0.3s;
    }

    @keyframes floaty {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-3px);
        }
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('navbarCanvas');
        const ctx = canvas.getContext('2d');

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = 80;
        }

        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const blobs = Array.from({
            length: 10
        }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 20 + 10,
            dx: (Math.random() - 0.5) * 1.5,
            dy: (Math.random() - 0.5) * 1.5,
            color: `rgba(${Math.floor(Math.random()*255)}, ${Math.floor(Math.random()*255)}, 255, 0.2)`
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
