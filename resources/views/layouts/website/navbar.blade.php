<nav style="background-color: #353866; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center;">
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
</nav>
