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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
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
                            <label class="p-label">Cover Image URL</label>
                            <input id="image_url" name="image_url" type="url" class="p-input mt-1" placeholder="https://..." />
                        </div>
                        <div class="pt-4 mt-2">
                            <button type="submit" class="p-btn w-full flex justify-center items-center">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Save Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Properties Card -->
            <div class="lg:col-span-2 flex flex-col gap-8">
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
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center text-sm text-gray-600">
                                                <i data-lucide="map-pin" class="w-3.5 h-3.5 mr-1.5 text-orange-400"></i>
                                                {{ $property->location }}
                                            </div>
                                            @if($property->phone)
                                            <div class="flex items-center text-sm text-gray-600">
                                                <i data-lucide="phone" class="w-3.5 h-3.5 mr-1.5 text-orange-400"></i>
                                                {{ $property->phone }}
                                            </div>
                                            @endif
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
                                            <button class="bg-orange-100 hover:bg-orange-200 text-[#e06828] p-2 rounded-lg transition-colors" title="Edit Property">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <form action="{{ route('property.delete', $property->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to securely delete {{ $property->name }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Delete Property">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
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
            </div>
        </div>
    </div>
</x-admin-layout>
