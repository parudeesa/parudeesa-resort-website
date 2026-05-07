<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Parudeesa Resort') }} - Super Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .parudeesa-bg { background-color: #fff3ec !important; font-family: 'Poppins', sans-serif !important; }
            .p-serif { font-family: 'Playfair Display', serif !important; }
            .p-card { background: #fff8f3; border: 1px solid rgba(250,135,62,.15); box-shadow: 0 6px 32px rgba(250,135,62,.15); border-radius: 16px; }
            .p-btn { background: linear-gradient(135deg, #fa873e, #e06828); color: white; border: none; padding: 0.6rem 1.5rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; border-radius: 8px; box-shadow: 0 4px 18px rgba(250,135,62,.35); transition: transform 0.3s ease; }
            .p-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(250,135,62,.45); color: white; }
            .p-input { border: 1.5px solid rgba(250,135,62,.25); border-radius: 8px; padding: 0.5rem 1rem; width: 100%; box-shadow: none !important; }
            .p-input:focus { border-color: #e06828; outline: none; }
            .p-label { color: #e06828; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase; }
            .p-text { color: #3e2010; }

            /* Tooltip */
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-sans antialiased parudeesa-bg text-[#3e2010]">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="w-64 flex-shrink-0 bg-white border-r border-orange-100 hidden md:flex flex-col shadow-lg z-20">
                <div class="h-16 flex items-center px-6 border-b border-orange-100 bg-orange-50/50">
                    <h1 class="p-serif text-2xl font-bold text-[#e06828] truncate">Parudeesa</h1>
                </div>
                <div class="flex-1 overflow-y-auto py-4">
                    <nav class="px-4 space-y-2">
                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                            Dashboard
                        </a>
                        @endif

                        @if(!auth()->user()->isCustomer())
                        <a href="{{ route('properties.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('properties.*') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="home" class="w-5 h-5 mr-3"></i>
                            {{ auth()->user()->isSuperAdmin() ? 'Properties' : 'My Properties' }}
                        </a>

                        <a href="{{ route('amenities.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('amenities.*') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="sparkles" class="w-5 h-5 mr-3"></i>
                            Amenities
                        </a>

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.admins.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                            Admins
                        </a>

                        <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.coupons.*') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="ticket" class="w-5 h-5 mr-3"></i>
                            Coupons
                        </a>
                        @endif
                        @endif

                        <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('bookings.*') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="calendar-check" class="w-5 h-5 mr-3"></i>
                            {{ auth()->user()->isCustomer() ? 'My Bookings' : 'Bookings' }}
                        </a>

                        @if(!auth()->user()->isCustomer())
                        <a href="{{ route('admin.calendar') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.calendar') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="calendar-days" class="w-5 h-5 mr-3"></i>
                            Google Calendar
                        </a>

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('admin.settings') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                            Settings
                        </a>
                        @endif

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-xl transition-colors {{ request()->routeIs('profile.edit') ? 'bg-orange-100 text-[#e06828] font-semibold' : 'text-gray-600 hover:bg-orange-50 hover:text-[#e06828]' }}">
                            <i data-lucide="user-cog" class="w-5 h-5 mr-3"></i>
                            Profile Settings
                        </a>
                        @endif
                        @endif
                    </nav>
                </div>
                <div class="p-4 border-t border-orange-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl transition-colors">
                            <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content wrapper -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-orange-100 flex-shrink-0 z-10">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                        <div class="flex items-center">
                            <!-- Mobile Menu Button -->
                            <button class="md:hidden mr-4 text-gray-500 hover:text-[#e06828]">
                                <i data-lucide="menu" class="w-6 h-6"></i>
                            </button>
                            @isset($header)
                                {{ $header }}
                            @endisset
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name ?? 'Admin User' }}</span>
                            @if(Auth::check() && Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="h-8 w-8 rounded-full object-cover border-2 border-orange-200">
                            @else
                                <div class="h-8 w-8 rounded-full bg-gradient-to-tr from-[#fa873e] to-[#e06828] flex items-center justify-center text-white font-bold">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-[#fff3ec] p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            lucide.createIcons();
        </script>
    </body>
</html>
