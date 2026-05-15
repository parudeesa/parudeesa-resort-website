<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Activity Pricing Rules') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold p-serif text-[#3e2010] tracking-tight">Amenity Pricing Manager</h1>
                    <p class="text-gray-500 text-sm mt-2 flex items-center gap-2">
                        <i data-lucide="calculator" class="w-4 h-4 text-orange-300"></i>
                        Define complex pricing rules for activities like Kayaking, Boating, and more.
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50/50 border border-green-100 text-green-800 p-5 rounded-2xl shadow-sm flex items-center justify-between animate-fade-in backdrop-blur-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </div>
                        <span class="font-bold text-sm tracking-tight">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.pricing.amenities.update') }}" method="POST">
                @csrf
                
                <!-- Unified Water Activity Pricing Section -->
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-[#fa873e]/10 rounded-xl flex items-center justify-center text-[#e06828]">
                            <i data-lucide="waves" class="w-5 h-5"></i>
                        </div>
                        <h2 class="text-2xl font-bold p-serif text-[#3e2010]">Kayaking & Boating Pricing</h2>
                    </div>

                    <div class="p-card p-10 max-w-4xl">
                        <div class="flex items-center gap-4 mb-8 pb-6 border-b border-orange-50">
                            <div class="flex gap-2">
                                <i data-lucide="waves" class="w-6 h-6 text-[#e06828]"></i>
                                <i data-lucide="anchor" class="w-6 h-6 text-[#e06828]"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-[#3e2010]">Shared Activity Rules</h3>
                                <p class="text-xs text-gray-400 mt-1">Both Kayaking and Boating will follow these pricing conditions.</p>
                            </div>
                        </div>
                        
                        <div class="space-y-10">
                            <!-- Threshold Configuration -->
                            <div class="bg-orange-50/30 p-6 rounded-2xl border border-orange-100/50">
                                <label class="text-xs font-bold uppercase tracking-wider text-[#e06828] mb-3 block">Guest Count Threshold</label>
                                <div class="flex items-center gap-6">
                                    <div class="w-32">
                                        <input type="number" name="settings[water_activity_threshold]" value="{{ $settings['water_activity_threshold'] }}" class="p-input !text-lg font-bold" required>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-[#3e2010] font-medium">Define the point where pricing changes.</p>
                                        <p class="text-[11px] text-gray-400 mt-1 italic">Example: If set to 5, groups of 5+ get the lower rate.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Pricing Tiers -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative group">
                                    <div class="absolute -top-3 left-4 px-2 bg-white text-[10px] font-black uppercase tracking-widest text-[#e06828] z-10">Below {{ $settings['water_activity_threshold'] }} Guests</div>
                                    <div class="p-4 rounded-2xl border-2 border-orange-100 group-hover:border-[#fa873e] transition-all">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl font-bold text-[#3e2010]">₹</span>
                                            <input type="number" name="settings[water_activity_low_price]" value="{{ $settings['water_activity_low_price'] }}" class="w-full border-none p-0 focus:ring-0 text-2xl font-black text-[#3e2010]" required>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-2 font-semibold">PER PERSON RATE</p>
                                    </div>
                                </div>

                                <div class="relative group">
                                    <div class="absolute -top-3 left-4 px-2 bg-white text-[10px] font-black uppercase tracking-widest text-green-600 z-10">{{ $settings['water_activity_threshold'] }}+ Guests</div>
                                    <div class="p-4 rounded-2xl border-2 border-green-100 group-hover:border-green-500 transition-all">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl font-bold text-[#3e2010]">₹</span>
                                            <input type="number" name="settings[water_activity_high_price]" value="{{ $settings['water_activity_high_price'] }}" class="w-full border-none p-0 focus:ring-0 text-2xl font-black text-[#3e2010]" required>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-2 font-semibold">PER PERSON RATE (DISCOUNTED)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Individual Amenity Pricing Section -->
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-[#fa873e]/10 rounded-xl flex items-center justify-center text-[#e06828]">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <h2 class="text-2xl font-bold p-serif text-[#3e2010]">Standard Amenity Pricing</h2>
                    </div>

                    <div class="p-card overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-orange-50/50 border-b border-orange-100/50">
                                    <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Amenity Name</th>
                                    <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Pricing Type</th>
                                    <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Base Price (₹)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @foreach($amenities as $amenity)
                                <tr class="hover:bg-orange-50/30 transition-colors">
                                    <td class="px-8 py-6 font-bold text-[#3e2010]">{{ $amenity->name }}</td>
                                    <td class="px-8 py-6">
                                        <select name="amenities[{{ $amenity->id }}][pricing_type]" class="p-input !py-1 text-sm bg-white">
                                            <option value="per_person" {{ $amenity->pricing_type == 'per_person' ? 'selected' : '' }}>Per Person</option>
                                            <option value="per_unit" {{ $amenity->pricing_type == 'per_unit' ? 'selected' : '' }}>Flat Rate (Per Unit)</option>
                                        </select>
                                    </td>
                                    <td class="px-8 py-6">
                                        <input type="number" name="amenities[{{ $amenity->id }}][price]" value="{{ $amenity->price }}" class="p-input !py-1 text-sm bg-white" required>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sheesha & Other Settings -->
                <div class="mb-12">
                    <div class="p-card p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <i data-lucide="settings" class="w-6 h-6 text-[#e06828]"></i>
                            <h3 class="text-xl font-bold text-[#3e2010]">Other Pricing Configurations</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="max-w-md">
                                <label class="p-label mb-2 block">Sheesha Max Capacity (Per Unit)</label>
                                <input type="number" name="settings[sheesha_capacity]" value="{{ $settings['sheesha_capacity'] }}" class="p-input" required>
                                <p class="text-[10px] text-gray-400 mt-1 italic">Limits how many participants can be assigned to one Sheesha unit.</p>
                            </div>
                            <div class="max-w-md">
                                <label class="p-label mb-2 block">Property Stay Guest Threshold</label>
                                <input type="number" name="settings[property_stay_threshold]" value="{{ $settings['property_stay_threshold'] }}" class="p-input" required>
                                <p class="text-[10px] text-gray-400 mt-1 italic">Guest count limit for standard weekday pricing (e.g., if 5, groups of 6+ get the higher rate).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="p-btn flex items-center gap-3 px-12 py-5 shadow-2xl">
                        <i data-lucide="save" class="w-5 h-5"></i>
                        <span>Save All Pricing Rules</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</x-admin-layout>
