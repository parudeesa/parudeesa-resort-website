<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Property Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold p-serif text-[#3e2010] tracking-tight">Property Portfolio</h1>
                    <p class="text-gray-500 text-sm mt-2 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4 text-orange-300"></i>
                        Manage your luxury resort stays, villa details, and guest amenities.
                    </p>
                </div>
                @if(auth()->user()->isSuperAdmin())
                <button onclick="openAddModal()" class="p-btn flex items-center gap-3 px-8 py-4 shadow-xl hover:shadow-orange-200/50 group transition-all duration-500 rounded-2xl">
                    <div class="bg-white/20 p-1.5 rounded-lg group-hover:rotate-90 transition-transform duration-500">
                        <i data-lucide="plus" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-sm font-bold uppercase tracking-widest">New Property</span>
                </button>
                @endif
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50/50 border border-green-100 text-green-800 p-5 rounded-2xl shadow-sm flex items-center justify-between animate-fade-in backdrop-blur-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 shadow-inner">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm tracking-tight">Success</p>
                            <p class="text-xs text-green-600/80">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-green-100 text-green-400 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Properties Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($properties as $property)
                    <div class="p-card overflow-hidden group hover:shadow-2xl transition-all duration-500 border border-orange-100/50">
                        <div class="relative h-56 overflow-hidden">
                            @if($property->image)
                                <img src="{{ asset($property->image) }}" alt="{{ $property->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-orange-50 flex items-center justify-center text-orange-200">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-lg {{ $property->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                    {{ $property->status ? 'Active' : 'Inactive' }}
                                </span>
                                @if($property->type)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-lg bg-orange-500 text-white">
                                    {{ $property->type }}
                                </span>
                                @endif
                            </div>
                            @if(auth()->user()->isSuperAdmin() && $property->admin_id)
                            <div class="absolute bottom-4 left-4">
                                <div class="px-2 py-1 rounded bg-black/40 backdrop-blur-md text-white text-[10px] font-bold uppercase border border-white/20">
                                    Admin: {{ \App\Models\User::find($property->admin_id)->name ?? 'Unknown' }}
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold p-serif text-[#3e2010] line-clamp-1 group-hover:text-[#e06828] transition-colors">{{ $property->name }}</h3>
                                <div class="text-right">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Stay Rates</div>
                                    <div class="flex flex-col gap-1">
                                        <div class="text-xs font-bold text-[#e06828] bg-orange-50 px-2 py-0.5 rounded flex justify-between gap-4">
                                            <span>Weekday (≤5):</span>
                                            <span>₹{{ number_format($property->weekday_price) }}</span>
                                        </div>
                                        <div class="text-xs font-bold text-[#e06828] bg-orange-50 px-2 py-0.5 rounded flex justify-between gap-4">
                                            <span>Weekday (≤10):</span>
                                            <span>₹{{ number_format($property->weekday_tier2_price) }}</span>
                                        </div>
                                        <div class="text-xs font-bold text-[#e06828] bg-orange-50 px-2 py-0.5 rounded flex justify-between gap-4">
                                            <span>Weekend (≤10):</span>
                                            <span>₹{{ number_format($property->weekend_price) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 text-sm mb-5 line-clamp-2 min-h-[40px]">{{ $property->description }}</p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-2 text-gray-500">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-orange-400"></i>
                                    <span class="text-xs font-medium truncate">{{ $property->location ?: 'Not set' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-500">
                                    <i data-lucide="users" class="w-4 h-4 text-orange-400"></i>
                                    <span class="text-xs font-medium">{{ $property->capacity ? $property->capacity . ' Persons' : 'No limit' }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2 pt-4 border-t border-orange-50">
                                <button onclick="editProperty(JSON.parse(this.dataset.property))" data-property="{{ json_encode($property->load('amenities')) }}" class="flex-1 py-2.5 bg-white border border-orange-200 text-orange-600 rounded-xl hover:bg-orange-50 transition-all font-bold text-sm flex items-center justify-center gap-2">
                                    <i data-lucide="pencil" class="w-4 h-4"></i> Edit
                                </button>
                                <a href="{{ route('property.show', $property->id) }}" target="_blank" class="p-2.5 bg-gray-50 text-gray-400 rounded-xl hover:bg-gray-100 hover:text-gray-600 transition-all border border-gray-100">
                                    <i data-lucide="external-link" class="w-5 h-5"></i>
                                </a>
                                @if(auth()->user()->isSuperAdmin())
                                <form action="{{ route('property.delete', $property->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this property forever?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 bg-red-50 text-red-400 rounded-xl hover:bg-red-100 hover:text-red-600 transition-all border border-red-100">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 bg-white rounded-3xl border border-dashed border-orange-200 flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mb-4">
                            <i data-lucide="building-2" class="w-10 h-10 text-orange-200"></i>
                        </div>
                        <h3 class="text-xl font-bold p-serif text-gray-400">No Properties Found</h3>
                        <p class="text-gray-400 text-sm mt-2">Start by adding your first property.</p>
                        @if(auth()->user()->isSuperAdmin())
                        <button onclick="openAddModal()" class="mt-6 p-btn">Add Property</button>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $properties->links() }}
            </div>
        </div>
    </div>

    <!-- Add/Edit Property Modal -->
    <div id="propertyModal" class="fixed inset-0 bg-[#3e2010]/40 backdrop-blur-md hidden z-50 overflow-y-auto animate-fade-in">
        <div class="min-h-screen flex items-center justify-center p-4 md:p-8">
            <div class="bg-[#fffaf7] rounded-[2.5rem] max-w-6xl w-full shadow-2xl relative animate-slide-up border border-orange-100/50 overflow-hidden">
                
                <!-- Modal Header (Sticky) -->
                <div class="sticky top-0 bg-[#fffaf7]/90 backdrop-blur-xl z-20 px-10 py-6 border-b border-orange-100/50 flex justify-between items-center">
                    <div>
                        <h2 id="modalTitle" class="text-3xl font-extrabold p-serif text-[#3e2010] tracking-tight">Property Detail</h2>
                        <p id="modalSubtitle" class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Refine your luxury offering</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div id="loadingIndicator" class="hidden flex items-center gap-2 text-orange-400 px-4 py-2 bg-orange-50 rounded-full animate-pulse">
                            <i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                            <span class="text-[10px] font-bold uppercase tracking-widest">Fetching Data...</span>
                        </div>
                        <button onclick="closeModal()" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400 hover:text-orange-500 hover:shadow-lg transition-all duration-300 border border-orange-50">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>
                </div>

                <form id="propertyForm" method="POST" enctype="multipart/form-data" class="px-10 py-8">
                    @csrf
                    <div id="methodField"></div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        
                        <!-- Left Column: Main Details -->
                        <div class="lg:col-span-8 space-y-10">
                            
                            <!-- Section: General Information -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center gap-3 mb-8 border-b border-orange-50 pb-4">
                                    <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="text-xl font-bold p-serif text-[#3e2010]">General Information</h3>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="md:col-span-2">
                                        <label class="p-label flex items-center gap-2 mb-2">
                                            Property Name
                                            <span class="text-red-400">*</span>
                                        </label>
                                        <input type="text" name="name" id="p_name" class="p-input bg-white focus:shadow-xl transition-all" placeholder="e.g. Presidential Waterfront Suite" required>
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label class="p-label flex items-center gap-2 mb-2">Detailed Description</label>
                                        <textarea name="description" id="p_description" class="p-input bg-white focus:shadow-xl transition-all min-h-[140px]" rows="4" placeholder="Craft a compelling narrative for this property..." required></textarea>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <label class="p-label flex items-center gap-2 mb-2">Property Type</label>
                                            <div class="relative group">
                                                <i data-lucide="tag" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-orange-300 group-focus-within:text-orange-500 transition-colors"></i>
                                                <input type="text" name="type" id="p_type" class="p-input bg-white pl-12" placeholder="e.g. Private Villa">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="p-label flex items-center gap-2 mb-2">Specific Location</label>
                                            <div class="relative group">
                                                <i data-lucide="map-pin" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-orange-300 group-focus-within:text-orange-500 transition-colors"></i>
                                                <input type="text" name="location" id="p_location" class="p-input bg-white pl-12" placeholder="e.g. Sunset Point, North Wing">
                                            </div>
                                        </div>
                                        <div>
                                            <label class="p-label flex items-center gap-2 mb-2">Max Capacity</label>
                                            <input type="number" name="capacity" id="p_capacity" class="p-input bg-white" placeholder="10" min="1">
                                        </div>
                                        <div>
                                            <label class="p-label flex items-center gap-2 mb-2">Contact WhatsApp</label>
                                            <div class="relative group">
                                                <i data-lucide="phone" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-orange-300 group-focus-within:text-orange-500 transition-colors"></i>
                                                <input type="text" name="phone" id="p_phone" class="p-input bg-white pl-12" placeholder="10-digit mobile number" maxlength="10">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Property Highlights -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center justify-between mb-8 border-b border-orange-50 pb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                            <i data-lucide="sparkles" class="w-5 h-5"></i>
                                        </div>
                                        <h3 class="text-xl font-bold p-serif text-[#3e2010]">Property Highlights</h3>
                                    </div>
                                    <span class="text-[10px] font-bold text-orange-300 uppercase tracking-widest">Max 5 Highlights</span>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                                    @for($i = 0; $i < 5; $i++)
                                    <div class="group relative p-6 rounded-3xl bg-white border border-orange-50 hover:border-orange-200 hover:shadow-xl transition-all duration-500">
                                        <div class="flex flex-col md:flex-row gap-6 items-center">
                                            <!-- Highlight Image Area -->
                                            <div class="w-full md:w-32 h-24 shrink-0 relative rounded-2xl overflow-hidden bg-orange-50 border border-dashed border-orange-200">
                                                <div id="h_img_preview_container_{{ $i }}" class="hidden w-full h-full">
                                                    <img id="h_img_preview_{{ $i }}" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                        <button type="button" onclick="clearHighlightImage({{ $i }})" class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <label for="h_img_{{ $i }}" class="cursor-pointer w-full h-full flex flex-col items-center justify-center text-orange-200 hover:text-orange-400 transition-colors">
                                                    <i data-lucide="image-plus" class="w-6 h-6 mb-1"></i>
                                                    <span class="text-[8px] font-bold uppercase tracking-widest">Upload</span>
                                                </label>
                                                <input name="highlights[{{ $i }}][image_file]" type="file" id="h_img_{{ $i }}" class="hidden highlight-image-input" accept="image/*" onchange="previewHighlightImage(this, {{ $i }})">
                                                <input type="hidden" name="highlights[{{ $i }}][image]" class="highlight-image-path">
                                            </div>

                                            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Label</label>
                                                    <input name="highlights[{{ $i }}][label]" type="text" class="p-input bg-[#fffaf7] text-sm highlight-label" placeholder="e.g. Private Balcony">
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Icon Class</label>
                                                    <div class="relative">
                                                        <i data-lucide="info" class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 text-orange-200"></i>
                                                        <input name="highlights[{{ $i }}][icon]" type="text" class="p-input bg-[#fffaf7] text-xs pl-9 highlight-icon" placeholder="bi bi-star">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>

                            <!-- Section: Accommodation -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center justify-between mb-8 border-b border-orange-50 pb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                            <i data-lucide="bed" class="w-5 h-5"></i>
                                        </div>
                                        <h3 class="text-xl font-bold p-serif text-[#3e2010]">Accommodation</h3>
                                    </div>
                                    <button type="button" onclick="addDynamicField('accommodation')" class="text-[10px] font-bold text-orange-500 px-3 py-1 bg-orange-50 rounded-full hover:bg-orange-100 transition-colors border border-orange-100">
                                        Add More
                                    </button>
                                </div>
                                <div id="accommodation_container" class="space-y-4">
                                    <!-- Dynamic fields will be added here -->
                                </div>
                            </div>

                            <!-- Section: Outdoor Spaces -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center justify-between mb-8 border-b border-orange-50 pb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                            <i data-lucide="trees" class="w-5 h-5"></i>
                                        </div>
                                        <h3 class="text-xl font-bold p-serif text-[#3e2010]">Outdoor Spaces</h3>
                                    </div>
                                    <button type="button" onclick="addDynamicField('outdoor_spaces')" class="text-[10px] font-bold text-orange-500 px-3 py-1 bg-orange-50 rounded-full hover:bg-orange-100 transition-colors border border-orange-100">
                                        Add More
                                    </button>
                                </div>
                                <div id="outdoor_spaces_container" class="space-y-4">
                                    <!-- Dynamic fields will be added here -->
                                </div>
                            </div>

                            <!-- Section: Pricing Rules -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center gap-3 mb-8 border-b border-orange-50 pb-4">
                                    <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                        <i data-lucide="banknote" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="text-xl font-bold p-serif text-[#3e2010]">Pricing Rules</h3>
                                </div>
                                <div class="bg-orange-50/50 rounded-3xl p-8 border border-orange-100/50">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                        <div class="flex flex-col items-center">
                                            <label class="p-label block mb-3 text-[#e06828] text-xs font-bold uppercase tracking-widest text-center min-h-[22px] flex items-end justify-center">Weekday (≤5 Guests)</label>
                                            <div class="relative w-full group">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#e06828] font-bold text-sm pointer-events-none">₹</span>
                                                <input type="number" name="weekday_price" id="p_weekday_price" class="p-input bg-white !pl-10 !pr-4 !py-4 font-extrabold text-[#3e2010] text-xl text-center focus:border-[#e06828] transition-all duration-300 shadow-lg" placeholder="8000">
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <label class="p-label block mb-3 text-[#e06828] text-xs font-bold uppercase tracking-widest text-center min-h-[22px] flex items-end justify-center">Weekday (≤10 Guests)</label>
                                            <div class="relative w-full group">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#e06828] font-bold text-sm pointer-events-none">₹</span>
                                                <input type="number" name="weekday_tier2_price" id="p_weekday_tier2_price" class="p-input bg-white !pl-10 !pr-4 !py-4 font-extrabold text-[#3e2010] text-xl text-center focus:border-[#e06828] transition-all duration-300 shadow-lg" placeholder="11000">
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <label class="p-label block mb-3 text-[#e06828] text-xs font-bold uppercase tracking-widest text-center min-h-[22px] flex items-end justify-center">Weekend (≤10 Guests)</label>
                                            <div class="relative w-full group">
                                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#e06828] font-bold text-sm pointer-events-none">₹</span>
                                                <input type="number" name="weekend_price" id="p_weekend_price" class="p-input bg-white !pl-10 !pr-4 !py-4 font-extrabold text-[#3e2010] text-xl text-center focus:border-[#e06828] transition-all duration-300 shadow-lg" placeholder="12000">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Media & Sidebar -->
                        <div class="lg:col-span-4 space-y-10">
                            
                            <!-- Section: Cover & Media -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center gap-3 mb-8 border-b border-orange-50 pb-4">
                                    <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                        <i data-lucide="image" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="text-xl font-bold p-serif text-[#3e2010]">Media Center</h3>
                                </div>

                                <div class="space-y-8">
                                    <!-- Main Cover -->
                                    <div>
                                        <label class="p-label mb-3 block">Primary Cover Image</label>
                                        <div class="group relative rounded-[2rem] overflow-hidden border-2 border-dashed border-orange-100 hover:border-orange-300 transition-all aspect-[4/3] bg-orange-50/30">
                                            <div id="imagePreview" class="w-full h-full flex flex-col items-center justify-center text-orange-200 p-2">
                                                <i data-lucide="upload-cloud" class="w-12 h-12 mb-3"></i>
                                                <span class="text-[10px] font-bold uppercase tracking-widest">Select Hero Image</span>
                                            </div>
                                            <label for="p_image" class="absolute inset-0 cursor-pointer z-10"></label>
                                            <input type="file" name="image" id="p_image" class="hidden" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                            
                                            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 scale-90 group-hover:scale-100">
                                                <div class="bg-white/90 backdrop-blur px-4 py-2 rounded-full shadow-xl border border-orange-100 flex items-center gap-2">
                                                    <i data-lucide="camera" class="w-3.5 h-3.5 text-orange-500"></i>
                                                    <span class="text-[10px] font-bold text-[#3e2010] uppercase tracking-tighter">Click to Change</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gallery -->
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <label class="p-label">Property Gallery</label>
                                            <label for="p_gallery" class="text-[10px] font-bold text-orange-500 px-3 py-1 bg-orange-50 rounded-full hover:bg-orange-100 transition-colors cursor-pointer border border-orange-100">
                                                Add More
                                            </label>
                                            <input type="file" name="gallery_images[]" id="p_gallery" class="hidden" multiple accept="image/*" onchange="previewGallery(this)">
                                        </div>
                                        
                                        <div id="galleryContainer" class="grid grid-cols-2 gap-4">
                                            <!-- Existing & New Gallery Previews -->
                                        </div>
                                        
                                        <div id="galleryEmptyState" class="py-12 border-2 border-dashed border-orange-100 rounded-3xl flex flex-col items-center justify-center text-orange-200">
                                            <i data-lucide="images" class="w-10 h-10 mb-2 opacity-50"></i>
                                            <span class="text-[10px] font-bold uppercase tracking-widest">Gallery Empty</span>
                                        </div>
                                        
                                        <div id="removeImagesContainer"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Settings & Meta -->
                            <div class="p-card p-8 rounded-[2rem]">
                                <div class="flex items-center gap-3 mb-8 border-b border-orange-50 pb-4">
                                    <div class="w-10 h-10 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600">
                                        <i data-lucide="settings" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="text-xl font-bold p-serif text-[#3e2010]">Config</h3>
                                </div>

                                <div class="space-y-8">
                                    @if(auth()->user()->isSuperAdmin())
                                    <div>
                                        <label class="p-label mb-2 block">Assigned Resort Admin</label>
                                        <select name="admin_id" id="p_admin_id" class="p-input bg-white">
                                            <option value="">Public Portfolio (No Admin)</option>
                                            @foreach($admins as $admin)
                                                <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif

                                    <div id="statusField">
                                        <label class="p-label mb-2 block">Listing Visibility</label>
                                        <div class="grid grid-cols-2 gap-4">
                                            <label class="cursor-pointer group">
                                                <input type="radio" name="status" value="1" id="p_status_active" class="hidden peer">
                                                <div class="p-4 rounded-2xl border border-orange-50 bg-white text-center peer-checked:bg-green-50 peer-checked:border-green-200 peer-checked:text-green-700 transition-all hover:shadow-md">
                                                    <i data-lucide="eye" class="w-5 h-5 mx-auto mb-1"></i>
                                                    <span class="text-[10px] font-bold uppercase tracking-widest">Active</span>
                                                </div>
                                            </label>
                                            <label class="cursor-pointer group">
                                                <input type="radio" name="status" value="0" id="p_status_inactive" class="hidden peer">
                                                <div class="p-4 rounded-2xl border border-orange-50 bg-white text-center peer-checked:bg-red-50 peer-checked:border-red-200 peer-checked:text-red-700 transition-all hover:shadow-md">
                                                    <i data-lucide="eye-off" class="w-5 h-5 mx-auto mb-1"></i>
                                                    <span class="text-[10px] font-bold uppercase tracking-widest">Draft</span>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="p-label mb-3 block">Guest Amenities</label>
                                        <div class="grid grid-cols-1 gap-2 max-h-60 overflow-y-auto p-4 bg-white rounded-3xl border border-orange-50 shadow-inner">
                                            @foreach($amenities as $amenity)
                                            <label class="flex items-center gap-3 p-3 rounded-2xl hover:bg-orange-50 transition-all cursor-pointer group border border-transparent hover:border-orange-100">
                                                <div class="relative w-5 h-5">
                                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="peer w-5 h-5 rounded-lg border-2 border-orange-100 text-[#e06828] focus:ring-[#e06828] transition-all">
                                                    <div class="absolute inset-0 bg-[#e06828] rounded-lg opacity-0 peer-checked:opacity-100 transition-opacity flex items-center justify-center text-white pointer-events-none">
                                                        <i data-lucide="check" class="w-3 h-3"></i>
                                                    </div>
                                                </div>
                                                <span class="text-xs font-bold text-gray-600 group-hover:text-[#e06828] transition-colors">{{ $amenity->name }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Bar (Sticky Bottom) -->
                    <div class="sticky bottom-0 bg-[#fffaf7]/90 backdrop-blur-xl -mx-10 -mb-8 px-10 py-6 border-t border-orange-100/50 mt-10 flex justify-end items-center gap-6 z-20">
                        <button type="button" onclick="closeModal()" class="px-8 py-3 text-gray-400 font-bold uppercase tracking-widest text-[10px] hover:text-orange-500 transition-all">Discard Changes</button>
                        <button type="submit" class="p-btn min-w-[280px] py-4 rounded-2xl shadow-2xl shadow-orange-200 flex items-center justify-center gap-3 group">
                            <span id="submitBtnText" class="text-sm">Finalize Listing</span>
                            <div id="submitLoader" class="hidden animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                            <i data-lucide="chevron-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        .animate-slide-up { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <script>
        let removedGalleryImages = [];

        function openAddModal() {
            const modal = document.getElementById('propertyModal');
            const form = document.getElementById('propertyForm');
            const methodField = document.getElementById('methodField');
            
            form.action = "{{ route('property.store') }}";
            methodField.innerHTML = '';
            
            document.getElementById('modalTitle').innerText = 'New Property';
            document.getElementById('modalSubtitle').innerText = 'Add a new luxury destination';
            document.getElementById('statusField').classList.add('hidden');
            document.getElementById('submitBtnText').innerText = 'Save Property';
            
            form.reset();
            removedGalleryImages = [];
            updateRemoveInputs();
            
            document.getElementById('imagePreview').innerHTML = `
                <i data-lucide="upload-cloud" class="w-12 h-12 mb-3"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest">Select Hero Image</span>
            `;
            
            document.getElementById('galleryContainer').innerHTML = '';
            document.getElementById('galleryEmptyState').classList.remove('hidden');

            // Reset Highlights
            document.getElementById('p_weekday_tier2_price').value = '';
            document.getElementById('p_weekend_tier2_price').value = '';
            for(let i=0; i<5; i++) clearHighlightImage(i);

            // Reset dynamic fields
            document.getElementById('accommodation_container').innerHTML = '';
            document.getElementById('outdoor_spaces_container').innerHTML = '';
            // Add one default row for each
            addDynamicField('accommodation');
            addDynamicField('outdoor_spaces');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            lucide.createIcons();
        }

        async function editProperty(property) {
            const modal = document.getElementById('propertyModal');
            const form = document.getElementById('propertyForm');
            const methodField = document.getElementById('methodField');
            const loading = document.getElementById('loadingIndicator');
            
            loading.classList.remove('hidden');
            
            form.action = `/property/${property.id}`;
            methodField.innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            
            document.getElementById('modalTitle').innerText = 'Edit Property';
            document.getElementById('modalSubtitle').innerText = 'Refine your hospitality content';
            document.getElementById('statusField').classList.remove('hidden');
            document.getElementById('submitBtnText').innerText = 'Update Listing';
            
            form.reset();
            removedGalleryImages = [];
            updateRemoveInputs();
            
            // Fill basic info
            document.getElementById('p_name').value = property.name;
            document.getElementById('p_description').value = property.description;
            document.getElementById('p_type').value = property.type || '';
            document.getElementById('p_location').value = property.location || '';
            document.getElementById('p_weekday_price').value = property.weekday_price || '';
            document.getElementById('p_weekday_tier2_price').value = property.weekday_tier2_price || '';
            document.getElementById('p_weekend_price').value = property.weekend_price || '';
            document.getElementById('p_capacity').value = property.capacity || '';
            document.getElementById('p_phone').value = property.phone || '';
            
            // Status Radio
            if (property.status) {
                document.getElementById('p_status_active').checked = true;
            } else {
                document.getElementById('p_status_inactive').checked = true;
            }
            
            if (document.getElementById('p_admin_id')) {
                document.getElementById('p_admin_id').value = property.admin_id || '';
            }

            // Cover Image Preview
            if (property.image) {
                document.getElementById('imagePreview').innerHTML = `
                    <img src="{{ asset('') }}${property.image}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/20"></div>
                `;
            } else {
                document.getElementById('imagePreview').innerHTML = `
                    <i data-lucide="upload-cloud" class="w-12 h-12 mb-3"></i>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Select Hero Image</span>
                `;
            }

            // Amenities
            const amenityCheckboxes = form.querySelectorAll('input[name="amenities[]"]');
            const propertyAmenityIds = property.amenities.map(a => a.id);
            amenityCheckboxes.forEach(cb => {
                cb.checked = propertyAmenityIds.includes(parseInt(cb.value));
            });

            // Gallery
            const galleryContainer = document.getElementById('galleryContainer');
            galleryContainer.innerHTML = '';
            const gallery = property.gallery_images || [];
            
            if (gallery.length > 0) {
                document.getElementById('galleryEmptyState').classList.add('hidden');
                gallery.forEach(img => addGalleryPreview(img, true));
            } else {
                document.getElementById('galleryEmptyState').classList.remove('hidden');
            }

            // Highlights
            const highlights = property.highlights || [];
            const highlightLabels = form.querySelectorAll('.highlight-label');
            const highlightIcons = form.querySelectorAll('.highlight-icon');
            const highlightPaths = form.querySelectorAll('.highlight-image-path');
            
            highlightLabels.forEach((label, index) => {
                const h = highlights[index] || {};
                label.value = h.label || '';
                highlightIcons[index].value = h.icon || '';
                highlightPaths[index].value = h.image || '';
                
                const previewContainer = document.getElementById(`h_img_preview_container_${index}`);
                const previewImg = document.getElementById(`h_img_preview_${index}`);
                
                if (h.image) {
                    const displaySrc = h.image.startsWith('http') ? h.image : `{{ asset('') }}${h.image}`;
                    previewImg.src = displaySrc;
                    previewContainer.classList.remove('hidden');
                } else {
                    previewContainer.classList.add('hidden');
                }
            });

            // Populate Accommodation
            const accContainer = document.getElementById('accommodation_container');
            accContainer.innerHTML = '';
            const accommodations = property.accommodation || [];
            if (accommodations.length > 0) {
                accommodations.forEach(val => addDynamicField('accommodation', val));
            } else {
                addDynamicField('accommodation');
            }

            // Populate Outdoor Spaces
            const outContainer = document.getElementById('outdoor_spaces_container');
            outContainer.innerHTML = '';
            const outdoorSpaces = property.outdoor_spaces || [];
            if (outdoorSpaces.length > 0) {
                outdoorSpaces.forEach(val => addDynamicField('outdoor_spaces', val));
            } else {
                addDynamicField('outdoor_spaces');
            }

            loading.classList.add('hidden');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            lucide.createIcons();
        }

        function closeModal() {
            document.getElementById('propertyModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewGallery(input) {
            if (input.files) {
                document.getElementById('galleryEmptyState').classList.add('hidden');
                Array.from(input.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        addGalleryPreview(e.target.result, false);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function addGalleryPreview(src, isExisting) {
            const container = document.getElementById('galleryContainer');
            const div = document.createElement('div');
            div.className = "relative group rounded-2xl overflow-hidden border border-orange-50 bg-orange-50 aspect-square shadow-sm hover:shadow-xl transition-all duration-500";
            
            const displaySrc = isExisting ? `{{ asset('') }}${src}` : src;
            
            div.innerHTML = `
                <img src="${displaySrc}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                    <button type="button" onclick="removePreview(this, '${isExisting ? src : ''}')" class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
            lucide.createIcons();
        }

        function removePreview(btn, path) {
            const div = btn.closest('.relative');
            div.remove();
            
            if (path) {
                removedGalleryImages.push(path);
                updateRemoveInputs();
            }
            
            const container = document.getElementById('galleryContainer');
            if (container.children.length === 0) {
                document.getElementById('galleryEmptyState').classList.remove('hidden');
            }
        }

        function updateRemoveInputs() {
            const container = document.getElementById('removeImagesContainer');
            container.innerHTML = '';
            removedGalleryImages.forEach(path => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_gallery_images[]';
                input.value = path;
                container.appendChild(input);
            });
        }

        function previewHighlightImage(input, index) {
            const previewContainer = document.getElementById(`h_img_preview_container_${index}`);
            const previewImg = document.getElementById(`h_img_preview_${index}`);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearHighlightImage(index) {
            const input = document.getElementById(`h_img_${index}`);
            const pathInput = document.querySelector(`input[name="highlights[${index}][image]"]`);
            const previewContainer = document.getElementById(`h_img_preview_container_${index}`);
            const previewImg = document.getElementById(`h_img_preview_${index}`);

            input.value = '';
            if (pathInput) pathInput.value = '';
            previewImg.src = '';
            previewContainer.classList.add('hidden');
        }

        function addDynamicField(type, value = '') {
            const container = document.getElementById(`${type}_container`);
            const div = document.createElement('div');
            div.className = "flex gap-4 animate-fade-in";
            div.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="${type}[]" value="${value}" class="p-input bg-white" placeholder="e.g. ${type === 'accommodation' ? 'Luxury Suite' : 'Poolside Deck'}">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="w-12 h-12 rounded-2xl bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-all flex items-center justify-center border border-red-100">
                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                </button>
            `;
            container.appendChild(div);
            lucide.createIcons();
        }

        document.getElementById('propertyForm').addEventListener('submit', function() {
            document.getElementById('submitBtnText').innerText = 'Syncing Portfolio...';
            document.getElementById('submitLoader').classList.remove('hidden');
            document.querySelector('button[type="submit"]').disabled = true;
        });

        document.getElementById('propertyModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
</x-admin-layout>
