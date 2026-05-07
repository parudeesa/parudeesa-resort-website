<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Property Management
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                <p class="font-bold mr-2">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 {{ auth()->user()->isSuperAdmin() ? 'lg:grid-cols-3' : '' }} gap-8">
            @if(auth()->user()->isSuperAdmin())
            <!-- Add Property Form -->
            <div class="lg:col-span-1">
                <div class="p-card p-6 sm:p-8 h-full sticky top-8">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="plus-circle" class="w-5 h-5 mr-2 text-[#e06828]"></i> Add New Property
                    </h3>
                    <form action="{{ route('property.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="p-label">Property Name</label>
                            <input id="name" name="name" type="text" class="p-input mt-1" placeholder="Parudeesa Utopiya" required />
                        </div>
                        <div>
                            <label class="p-label">Description</label>
                            <textarea id="description" name="description" class="p-input mt-1" rows="3" placeholder="Features..." required></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label">Price (INR)</label>
                                <input id="price" name="price" type="number" step="0.01" class="p-input mt-1" placeholder="5000" required />
                            </div>
                            <div>
                                <label class="p-label">Location</label>
                                <input id="location" name="location" type="text" class="p-input mt-1" placeholder="Kerala" required />
                            </div>
                        </div>
                        <div>
                            <label class="p-label">WhatsApp Number</label>
                            <input id="phone" name="phone" type="text" class="p-input mt-1" placeholder="918921021202" />
                        </div>
                        <div>
                            <label class="p-label">Assign Admin</label>
                            <select name="admin_id" class="p-input mt-1">
                                <option value="">Select an Admin (Optional)</option>
                                @foreach($admins as $admin)
                                <option value="{{ $admin->id }}">{{ $admin->name }} ({{ $admin->username }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="p-label">Cover Image URL</label>
                            <input id="image_url" name="image_url" type="url" class="p-input mt-1" placeholder="https://..." />
                        </div>
                        <div>
                            <label class="p-label">Carousel Images</label>
                            <div class="space-y-2 mt-1">
                                @for($i = 0; $i < 5; $i++)
                                <input name="gallery_images[]" type="url" class="p-input" placeholder="Carousel image {{ $i + 1 }} URL" />
                                @endfor
                            </div>
                        </div>
                        <div>
                            <label class="p-label">Amenities shown on card</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                                @foreach($amenities as $amenity)
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="p-checkbox">
                                    {{ $amenity->name }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="p-label">Highlights</label>
                            <div class="space-y-3 mt-2">
                                @for($i = 0; $i < 5; $i++)
                                <div class="grid grid-cols-1 gap-2 p-3 rounded-lg bg-orange-50/60 border border-orange-100">
                                    <input name="highlights[{{ $i }}][label]" type="text" class="p-input" placeholder="Highlight text">
                                    <input name="highlights[{{ $i }}][icon]" type="text" class="p-input" placeholder="Bootstrap icon, e.g. bi-stars">
                                    <input name="highlights[{{ $i }}][image]" type="url" class="p-input" placeholder="Highlight image URL">
                                </div>
                                @endfor
                            </div>
                        </div>
                        <div class="pt-4 mt-2">
                            <button type="submit" class="p-btn w-full flex justify-center items-center">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- List Properties Card -->
            <div class="{{ auth()->user()->isSuperAdmin() ? 'lg:col-span-2' : 'lg:col-span-3' }} flex flex-col gap-8">
                <div class="p-card p-6 sm:p-8 flex-1">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                        <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                            <i data-lucide="list" class="w-5 h-5 mr-2 text-[#e06828]"></i> Properties
                        </h3>
                        <div class="mt-4 sm:mt-0 relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" placeholder="Search properties..." class="p-input pl-10 text-sm py-2">
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                            <thead style="background:rgba(250,135,62,.05)">
                                <tr>
                                    <th class="px-6 py-4 text-left p-label rounded-tl-lg">Property</th>
                                    <th class="px-6 py-4 text-left p-label">Details</th>
                                    <th class="px-6 py-4 text-left p-label">Price</th>
                                    <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                                @foreach($properties as $property)
                                <tr class="hover:bg-orange-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($property->image_url)
                                            <img src="{{ $property->image_url }}" alt="" class="w-12 h-12 rounded-lg object-cover mr-4 border border-orange-100 shadow-sm">
                                            @else
                                            <div class="w-12 h-12 rounded-lg bg-orange-100 mr-4 flex items-center justify-center text-orange-400 border border-orange-200">
                                                <i data-lucide="image" class="w-6 h-6"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <div class="p-serif text-lg font-bold p-text">{{ $property->name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">ID: #{{ str_pad($property->id, 4, '0', STR_PAD_LEFT) }}</div>
                                                @if(auth()->user()->isSuperAdmin() && $property->admin_id)
                                                <div class="text-[10px] text-orange-600 font-bold uppercase tracking-tighter">Admin: {{ \App\Models\User::find($property->admin_id)->name ?? 'Unknown' }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <i data-lucide="sparkles" class="w-3.5 h-3.5 mr-1.5 text-orange-400"></i>
                                                {{ $property->amenities->pluck('name')->take(3)->join(', ') ?: 'Amenities not set' }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-[#e06828] bg-orange-50 px-3 py-1 rounded-full inline-block">
                                            ₹{{ number_format($property->price, 2) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('property.show', $property->id) }}" target="_blank" class="bg-gray-100 hover:bg-gray-200 text-gray-600 p-2 rounded-lg transition-colors" title="View Property">
                                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                            </a>
                                            <a href="#edit-property-{{ $property->id }}" onclick="document.querySelector('#edit-property-{{ $property->id }} details')?.setAttribute('open', 'open')" class="bg-orange-100 hover:bg-orange-200 text-[#e06828] p-2 rounded-lg transition-colors" title="Edit Property">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </a>
                                            @if(auth()->user()->isSuperAdmin())
                                            <form action="{{ route('property.delete', $property->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to securely delete {{ $property->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Delete Property">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr id="edit-property-{{ $property->id }}" class="bg-orange-50/30">
                                    <td colspan="4" class="px-6 py-5">
                                        <details class="rounded-xl border border-orange-100 bg-white p-4">
                                            <summary class="cursor-pointer font-bold text-[#e06828]">Edit {{ $property->name }} details, carousel, highlights, and amenities</summary>
                                            <form action="{{ route('property.update', $property) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                                @csrf
                                                @method('PATCH')
                                                <div>
                                                    <label class="p-label">Property Name</label>
                                                    <input name="name" type="text" value="{{ $property->name }}" class="p-input mt-1" required>
                                                </div>
                                                <div>
                                                    <label class="p-label">Price (INR)</label>
                                                    <input name="price" type="number" step="0.01" value="{{ $property->price }}" class="p-input mt-1" required>
                                                </div>
                                                <div>
                                                    <label class="p-label">Location</label>
                                                    <input name="location" type="text" value="{{ $property->location }}" class="p-input mt-1">
                                                </div>
                                                <div>
                                                    <label class="p-label">WhatsApp Number</label>
                                                    <input name="phone" type="text" value="{{ $property->phone }}" class="p-input mt-1">
                                                 </div>
                                                 @if(auth()->user()->isSuperAdmin())
                                                 <div>
                                                     <label class="p-label">Assign Admin</label>
                                                     <select name="admin_id" class="p-input mt-1">
                                                         <option value="">Select an Admin</option>
                                                         @foreach($admins as $admin)
                                                         <option value="{{ $admin->id }}" @selected($property->admin_id == $admin->id)>{{ $admin->name }} ({{ $admin->username }})</option>
                                                         @endforeach
                                                     </select>
                                                 </div>
                                                 @endif
                                                <div class="md:col-span-2">
                                                    <label class="p-label">Description</label>
                                                    <textarea name="description" class="p-input mt-1" rows="2">{{ $property->description }}</textarea>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="p-label">Cover Image URL</label>
                                                    <input name="image_url" type="url" value="{{ $property->image_url }}" class="p-input mt-1">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="p-label">Carousel Images</label>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-1">
                                                        @for($i = 0; $i < 5; $i++)
                                                        <input name="gallery_images[]" type="url" value="{{ $property->gallery_images[$i] ?? '' }}" class="p-input" placeholder="Carousel image {{ $i + 1 }} URL">
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="p-label">Amenities shown on card</label>
                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mt-2">
                                                        @foreach($amenities as $amenity)
                                                        <label class="flex items-center gap-2 text-sm text-gray-700">
                                                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" class="p-checkbox" @checked($property->amenities->contains($amenity->id))>
                                                            {{ $amenity->name }}
                                                        </label>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="p-label">Highlights</label>
                                                    <div class="grid grid-cols-1 gap-3 mt-2">
                                                        @for($i = 0; $i < 5; $i++)
                                                        @php($highlight = $property->highlights[$i] ?? [])
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 p-3 rounded-lg bg-orange-50/60 border border-orange-100">
                                                            <input name="highlights[{{ $i }}][label]" type="text" value="{{ $highlight['label'] ?? '' }}" class="p-input" placeholder="Highlight text">
                                                            <input name="highlights[{{ $i }}][icon]" type="text" value="{{ $highlight['icon'] ?? '' }}" class="p-input" placeholder="Bootstrap icon, e.g. bi-stars">
                                                            <input name="highlights[{{ $i }}][image]" type="url" value="{{ $highlight['image'] ?? '' }}" class="p-input" placeholder="Highlight image URL">
                                                        </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="md:col-span-2 flex justify-end">
                                                    <button type="submit" class="p-btn px-8">Update Property</button>
                                                </div>
                                            </form>
                                        </details>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if($properties->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center p-text">
                                        <div class="flex flex-col items-center justify-center">
                                            <i data-lucide="folder-open" class="w-12 h-12 text-orange-200 mb-3"></i>
                                            <p class="font-serif italic text-lg text-gray-500">No properties officially added yet.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $properties->links() }}
                    </div>
                </div>

                @if(auth()->user()->isSuperAdmin())
                <!-- Create Admin Card -->
                <div class="p-card p-6 sm:p-8">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="user-plus" class="w-5 h-5 mr-2 text-[#e06828]"></i> Create Admin User
                    </h3>
                    <form action="{{ route('admin.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @csrf
                        <div>
                            <label class="p-label">Full Name</label>
                            <input name="name" type="text" class="p-input mt-1" placeholder="John Doe" required>
                        </div>
                        <div>
                            <label class="p-label">Username</label>
                            <input name="username" type="text" class="p-input mt-1" placeholder="admin_john" required>
                        </div>
                        <div>
                            <label class="p-label">Password</label>
                            <input name="password" type="password" class="p-input mt-1" placeholder="••••••••" required>
                        </div>
                        <div class="md:col-span-3 flex justify-end mt-2">
                            <button type="submit" class="p-btn px-8">Create Admin Account</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
