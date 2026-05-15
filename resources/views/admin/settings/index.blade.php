<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Home Page Management') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ activeTab: 'home_hero' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold p-serif text-[#e06828]">Home Page Content</h1>
                    <p class="text-gray-500 text-sm mt-1">Customize every section of your website's home page.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center justify-between animate-fade-in">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                        <span class="font-bold">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Tabs -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="p-card sticky top-6">
                        <nav class="flex flex-col space-y-1 p-2">
                            <button @click="activeTab = 'home_hero'" :class="activeTab === 'home_hero' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="layout" class="w-5 h-5"></i>
                                Hero Section
                            </button>
                            <button @click="activeTab = 'home_properties'" :class="activeTab === 'home_properties' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="home" class="w-5 h-5"></i>
                                Properties
                            </button>
                            <button @click="activeTab = 'home_amenities'" :class="activeTab === 'home_amenities' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="sparkles" class="w-5 h-5"></i>
                                Amenities
                            </button>
                            <button @click="activeTab = 'home_events'" :class="activeTab === 'home_events' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="calendar" class="w-5 h-5"></i>
                                Events Banner
                            </button>
                            <button @click="activeTab = 'home_reviews'" :class="activeTab === 'home_reviews' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="message-square" class="w-5 h-5"></i>
                                Reviews
                            </button>
                            <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="phone" class="w-5 h-5"></i>
                                Contact Info
                            </button>
                            <button @click="activeTab = 'booking'" :class="activeTab === 'booking' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="calendar-check" class="w-5 h-5"></i>
                                Booking Policies
                            </button>
                            <button @click="activeTab = 'amenity_rules'" :class="activeTab === 'amenity_rules' ? 'bg-orange-50 text-[#e06828]' : 'text-gray-600 hover:bg-gray-50'" class="flex items-center gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i data-lucide="settings-2" class="w-5 h-5"></i>
                                Amenity Rules
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="flex-1">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        @foreach($settings as $group => $groupSettings)
                        <div x-show="activeTab === '{{ $group }}'" x-cloak class="space-y-6 animate-fade-in">
                            <div class="p-card p-8">
                                <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-6 capitalize">{{ str_replace(['home_', '_'], ['', ' '], $group) }} Settings</h3>
                                
                                <div class="grid grid-cols-1 gap-8">
                                    @foreach($groupSettings as $setting)
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold uppercase tracking-wider text-gray-400 block">{{ str_replace(['home_', '_'], ['', ' '], $setting->key) }}</label>
                                        
                                        @if($setting->type === 'text')
                                            <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="w-full p-input border-orange-100/50 focus:border-[#e06828] focus:ring-1 focus:ring-[#e06828] transition-all">
                                        @elseif($setting->type === 'textarea')
                                            <textarea name="{{ $setting->key }}" rows="4" class="w-full p-input border-orange-100/50 focus:border-[#e06828] focus:ring-1 focus:ring-[#e06828] transition-all">{{ $setting->value }}</textarea>
                                        @elseif($setting->type === 'image')
                                            <div class="flex flex-col md:flex-row gap-6 items-start">
                                                <div class="w-full md:w-1/2">
                                                    <div class="relative group cursor-pointer overflow-hidden rounded-2xl border-2 border-dashed border-orange-200 hover:border-[#e06828] transition-all aspect-video flex items-center justify-center bg-orange-50/30">
                                                        @if($setting->value)
                                                            <img src="{{ str_starts_with($setting->value, 'http') ? $setting->value : asset($setting->value) }}" id="preview-{{ $setting->key }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="text-center" id="placeholder-{{ $setting->key }}">
                                                                <i data-lucide="image-plus" class="w-12 h-12 text-orange-200 mx-auto mb-2"></i>
                                                                <span class="text-xs font-bold text-orange-300 uppercase">Upload Image</span>
                                                            </div>
                                                        @endif
                                                        <input type="file" name="{{ $setting->key }}" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this, '{{ $setting->key }}')">
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-400 mb-2 italic">Currently: {{ $setting->value ?: 'None' }}</p>
                                                    <p class="text-[10px] text-gray-500 font-medium">Recommended size: 1920x1080 for backgrounds, 1200x800 for sections. Max 2MB.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>

                                <div class="mt-10 pt-6 border-t border-orange-50">
                                    <button type="submit" class="p-btn w-full md:w-auto px-10 py-4 shadow-xl hover:shadow-2xl transition-all">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .p-input {
            background-color: #fff !important;
            border-radius: 1rem !important;
            padding: 0.875rem 1.25rem !important;
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        function previewImage(input, key) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-' + key);
                    if (preview) {
                        preview.src = e.target.result;
                    } else {
                        // Create image if it doesn't exist
                        const parent = input.parentElement;
                        const placeholder = document.getElementById('placeholder-' + key);
                        if (placeholder) placeholder.remove();
                        
                        const img = document.createElement('img');
                        img.id = 'preview-' + key;
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover';
                        parent.appendChild(img);
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>
