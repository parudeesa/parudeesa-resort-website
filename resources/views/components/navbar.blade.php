@props(['isHome' => false])

<style>
    /* ═══════ NAVBAR COMPONENT STYLES ═══════ */
    .navbar {
        background: rgba(255, 243, 236, .98) !important;
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(250, 135, 62, .18);
        box-shadow: 0 4px 28px rgba(250, 135, 62, .12);
        padding: .75rem 0;
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 2000 !important;
        transition: all 0.4s cubic-bezier(.4, 0, .2, 1);
    }

    .nav-link {
        font-family: 'Outfit', sans-serif;
        font-size: .85rem;
        font-weight: 500;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--txt-m) !important;
        padding: .45rem .85rem !important;
        border-radius: 50px;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .nav-link:hover, .nav-link.active {
        color: var(--brand) !important;
        background: rgba(250, 135, 62, .05);
    }

    .navbar-solid {
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        width: 100% !important;
        background: rgba(255, 243, 236, .98) !important;
        z-index: 9999 !important;
        transition: all .3s ease;
        padding: 10px 0;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }

    .navbar .container {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        max-width: 100% !important;
        padding: 0 20px !important;
    }

    @media (max-width: 991px) {
        .navbar-toggler {
            display: block !important;
            border: none !important;
            padding: 0 !important;
            outline: none !important;
            box-shadow: none !important;
        }
    }

    .navbar-toggler {
        border: 1px solid rgba(250, 135, 62, .3);
        padding: .4rem .6rem;
    }

    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23fa873e' stroke-width='2.5' stroke-linecap='round' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
    }

    @media (max-width: 991px) {
        .navbar-toggler {
            display: block !important;
            margin-right: 15px;
        }
        .navbar-collapse {
            background: #fff;
            margin-top: 10px;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .nav-link {
            padding: 12px 20px !important;
            border-radius: 10px;
        }
    }
</style>
<!-- Bootstrap JS Bundle (Required for Mobile Menu) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="navbar navbar-expand-lg navbar-solid" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}" @if($isHome) onclick="goPage('home');return false;" @endif>
            <img src="/images/parudeesa-logo.png" alt="Parudeesa Logo" style="height: 55px; width: auto; object-fit: contain;">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"
            aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list" style="color: var(--brand); font-size: 2.2rem;"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') && !request()->is('gallery') && !request()->is('about') ? 'active' : '' }}" 
                       id="nav-link-home"
                       href="{{ route('home') }}"
                       @if(request()->routeIs('home')) onclick="goPage('home'); return false;" @endif>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('events') ? 'active' : '' }}" 
                       id="nav-link-events"
                       href="{{ route('events') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" 
                       id="nav-link-gallery"
                       href="{{ route('home') }}#gallery"
                       @if(request()->routeIs('home')) onclick="goPage('gallery'); return false;" @endif>Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" 
                       id="nav-link-about"
                       href="{{ route('home') }}#about"
                       @if(request()->routeIs('home')) onclick="goPage('about'); return false;" @endif>About Us</a>
                </li>
                
                @auth
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; color: inherit; cursor: pointer;">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" id="nav-link-login" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
            
        </div>
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('mainNav');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>
