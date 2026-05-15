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
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">
        
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .parudeesa-bg { background-color: #fff3ec !important; font-family: 'Outfit', sans-serif !important; font-weight: 300; }
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
    <body class="font-sans antialiased parudeesa-bg text-[#3e2010]" x-data="{ sidebarOpen: false, contentMenuOpen: {{ request()->routeIs('admin.homepage-manager.*', 'admin.events-manager.*', 'admin.gallery', 'admin.reels.*', 'admin.about-us.*') ? 'true' : 'false' }} }">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar Backdrop (Mobile) -->
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false" 
                 class="fixed inset-0 bg-[#3e2010]/20 backdrop-blur-sm z-40 md:hidden"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
                   class="fixed inset-y-0 left-0 w-72 md:relative md:flex flex-col bg-[#F8F5F1] border-r border-[#fa873e]/10 shadow-[4px_0_24px_rgba(62,32,16,0.03)] z-50 transition-transform duration-300 ease-in-out">
                
                <div class="h-20 flex items-center px-8 border-b border-[#fa873e]/5">
                    <h1 class="p-serif text-2xl font-bold bg-gradient-to-r from-[#e06828] to-[#fa873e] bg-clip-text text-transparent">Parudeesa</h1>
                </div>

                <div class="flex-1 overflow-y-auto py-6 custom-scrollbar">
                    <nav class="px-5 space-y-1.5">
                        <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#e06828]/60">Main Navigation</div>
                        
                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="layout-dashboard" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Dashboard</span>
                        </a>
                        @endif

                        @if(!auth()->user()->isCustomer())
                        <a href="{{ route('properties.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('properties.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="home" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">{{ auth()->user()->isSuperAdmin() ? 'Properties' : 'My Properties' }}</span>
                        </a>

                        <a href="{{ route('amenities.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('amenities.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="sparkles" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Amenities</span>
                        </a>

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.yachts.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.yachts.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="ship" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Yachts</span>
                        </a>
                        @endif

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.admins.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.admins.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="users-round" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Admins</span>
                        </a>

                        <a href="{{ route('admin.coupons.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.coupons.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="ticket" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Coupons</span>
                        </a>

                        <a href="{{ route('admin.events.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.events.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="message-square-quote" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Event Inquiries</span>
                        </a>

                        <a href="{{ route('admin.pricing.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.pricing.index') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="banknote" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Pricing & Services</span>
                        </a>

                        <a href="{{ route('admin.pricing.amenities') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.pricing.amenities') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="calculator" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Activity Pricing Rules</span>
                        </a>
                        @endif
                        @endif

                        <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('bookings.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="calendar-check-2" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">{{ auth()->user()->isCustomer() ? 'My Bookings' : 'Bookings' }}</span>
                        </a>

                        @if(!auth()->user()->isCustomer())
                        <a href="{{ route('admin.calendar') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.calendar') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="calendar-range" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Google Calendar</span>
                        </a>
                        @endif

                        <div class="h-px bg-[#fa873e]/5 my-4 mx-3"></div>
                        <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-[#e06828]/60">Content & Settings</div>

                        @if(auth()->user()->isSuperAdmin())
                        <!-- Content Manager Dropdown -->
                        <div class="space-y-1">
                            <button @click="contentMenuOpen = !contentMenuOpen" 
                                    class="w-full flex items-center justify-between px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.homepage-manager.*', 'admin.events-manager.*', 'admin.gallery', 'admin.reels.*', 'admin.about-us.*') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                                <div class="flex items-center">
                                    <i data-lucide="layout-template" class="w-[18px] h-[18px] mr-3.5"></i>
                                    <span class="text-sm">Content Manager</span>
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300" :class="contentMenuOpen ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="contentMenuOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="pl-11 pr-2 py-1 space-y-1">
                                
                                <a href="{{ route('admin.homepage-manager.index') }}" class="flex items-center py-2 text-[13px] transition-colors {{ request()->routeIs('admin.homepage-manager.*') ? 'text-[#e06828] font-semibold' : 'text-[#3e2010]/60 hover:text-[#e06828]' }}">
                                    Home Manager
                                </a>
                                
                                <a href="{{ route('admin.events-manager.index') }}" class="flex items-center py-2 text-[13px] transition-colors {{ request()->routeIs('admin.events-manager.*') ? 'text-[#e06828] font-semibold' : 'text-[#3e2010]/60 hover:text-[#e06828]' }}">
                                    Events Manager
                                </a>

                                <a href="{{ route('admin.gallery') }}" class="flex items-center py-2 text-[13px] transition-colors {{ request()->routeIs('admin.gallery') ? 'text-[#e06828] font-semibold' : 'text-[#3e2010]/60 hover:text-[#e06828]' }}">
                                    Gallery Manager
                                </a>

                                <a href="{{ route('admin.about-us.index') }}" class="flex items-center py-2 text-[13px] transition-colors {{ request()->routeIs('admin.about-us.*') ? 'text-[#e06828] font-semibold' : 'text-[#3e2010]/60 hover:text-[#e06828]' }}">
                                    About Us Manager
                                </a>

                                <a href="{{ route('admin.reels.index') }}" class="flex items-center py-2 text-[13px] transition-colors {{ request()->routeIs('admin.reels.*') ? 'text-[#e06828] font-semibold' : 'text-[#3e2010]/60 hover:text-[#e06828]' }}">
                                    Instagram Reels
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('admin.settings') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="settings-2" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">General Settings</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 rounded-[16px] transition-all duration-300 {{ request()->routeIs('profile.edit') ? 'bg-white text-[#e06828] shadow-[0_4px_12px_rgba(224,104,40,0.08)] font-medium' : 'text-[#3e2010]/70 hover:bg-white/60 hover:text-[#e06828]' }}">
                            <i data-lucide="user-cog" class="w-[18px] h-[18px] mr-3.5"></i>
                            <span class="text-sm">Profile Settings</span>
                        </a>
                        @endif
                    </nav>
                </div>

                <div class="p-6 mt-auto border-t border-[#fa873e]/5">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-3.5 text-[#3e2010]/60 hover:text-red-500 hover:bg-red-50 rounded-[16px] transition-all duration-300 group">
                            <i data-lucide="log-out" class="w-[18px] h-[18px] mr-3.5 group-hover:stroke-red-500"></i>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </aside>

            <!-- Main Content wrapper -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Top Header -->
                <header class="bg-white/80 backdrop-blur-md shadow-sm border-b border-[#fa873e]/5 flex-shrink-0 z-10">
                    <div class="flex items-center justify-between h-20 px-6 sm:px-8">
                        <div class="flex items-center">
                            <!-- Mobile Menu Button -->
                            <button @click="sidebarOpen = true" class="md:hidden mr-4 p-2 rounded-xl bg-[#F8F5F1] text-[#3e2010]/60 hover:text-[#e06828] transition-colors">
                                <i data-lucide="menu" class="w-6 h-6"></i>
                            </button>
                            <div class="flex flex-col">
                                @isset($header)
                                    <div class="text-[#3e2010]/40 text-[10px] font-bold uppercase tracking-[0.2em] mb-0.5">Super Admin Dashboard</div>
                                    <div class="text-[#3e2010] font-semibold">{{ strip_tags($header) }}</div>
                                @endisset
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-end mr-2 hidden sm:flex">
                                <span class="text-sm font-bold text-[#3e2010]">{{ Auth::user()->name ?? 'Admin User' }}</span>
                                <span class="text-[10px] text-[#e06828] font-bold uppercase tracking-wider">{{ Auth::user()->role ?? 'Super Admin' }}</span>
                            </div>
                            @if(Auth::check() && Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="h-10 w-10 rounded-[14px] object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="h-10 w-10 rounded-[14px] bg-gradient-to-tr from-[#fa873e] to-[#e06828] flex items-center justify-center text-white font-bold shadow-md shadow-orange-200">
                                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto bg-[#fff3ec]/50 p-6 sm:p-8">
                    <div class="max-w-[1600px] mx-auto">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>

        <style>
            .custom-scrollbar::-webkit-scrollbar { width: 4px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(250,135,62,0.1); border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(250,135,62,0.2); }
        </style>

        <script>
            lucide.createIcons();
        </script>
        @stack('scripts')
    </body>
</html>
