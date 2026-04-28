<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Amenities Management
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto" x-data="amenitiesManager()">
        
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
            <!-- Add Amenity Form (1/3 width) -->
            <div class="lg:col-span-1">
                <div class="p-card p-6 sm:p-8 h-full">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="sparkles" class="w-5 h-5 mr-2 text-[#e06828]"></i> Add Amenity
                    </h3>
                    <form action="{{ route('amenities.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="p-label">Amenity Name</label>
                            <input id="name" name="name" type="text" class="p-input mt-1" placeholder="e.g. Infinity Pool" required />
                        </div>
                        <div>
                            <label class="p-label">Price</label>
                            <input id="price" name="price" type="number" min="0" step="0.01" class="p-input mt-1" placeholder="e.g. 1000" required />
                        </div>
                        <div>
                            <label class="p-label">Pricing Type</label>
                            <select id="pricing_type" name="pricing_type" class="p-input mt-1" required>
                                <option value="fixed">Fixed</option>
                                <option value="per_person">Per Person</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label">Description (Optional)</label>
                            <textarea id="description" name="description" class="p-input mt-1" rows="3" placeholder="Brief details..."></textarea>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 p-label">
                                <input id="status" name="status" type="checkbox" value="1" checked class="p-checkbox" />
                                Active
                            </label>
                        </div>
                        <div class="pt-4 mt-2">
                            <button type="submit" class="p-btn w-full flex justify-center items-center">
                                <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Amenity
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Amenities List Card (2/3 width) -->
            <div class="lg:col-span-2">
                <div class="p-card p-6 sm:p-8 h-full flex flex-col">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                        <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                            <i data-lucide="list" class="w-5 h-5 mr-2 text-[#e06828]"></i> Amenities
                        </h3>
                        <!-- Search Bar -->
                        <div class="mt-4 sm:mt-0 relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                            </div>
                            <input type="text" placeholder="Search amenities..." class="p-input pl-10 text-sm py-2">
                        </div>
                    </div>

                    @if($amenities->count() > 0)
                        <div class="overflow-x-auto flex-1">
                            <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                                <thead style="background:rgba(250,135,62,.05)">
                                    <tr>
                                        <th class="px-6 py-4 text-left p-label rounded-tl-lg">Name</th>
                                        <th class="px-6 py-4 text-left p-label">Price</th>
                                        <th class="px-6 py-4 text-left p-label">Pricing Type</th>
                                        <th class="px-6 py-4 text-left p-label">Description</th>
                                        <th class="px-6 py-4 text-left p-label">Created</th>
                                        <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                                    @foreach($amenities as $amenity)
                                        <tr class="hover:bg-orange-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-bold p-text text-md">{{ $amenity->name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-700">₹{{ number_format($amenity->price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold" style="background:rgba(250,135,62,.1);color:#b45309">{{ ucfirst(str_replace('_', ' ', $amenity->pricing_type)) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 truncate max-w-xs">{{ $amenity->description ?: '—' }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500">{{ $amenity->created_at->format('M d, Y') }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end space-x-2">
                                                    <!-- Edit Icon with Tooltip -->
                                                    <div class="relative flex items-center group/tooltip">
                                                        <button @click="openEditModal({{ $amenity->id }}, '{{ addslashes($amenity->name) }}', {{ $amenity->price }}, '{{ $amenity->pricing_type }}', {{ $amenity->status ? 'true' : 'false' }}, '{{ addslashes($amenity->description ?? '') }}')" 
                                                                class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors">
                                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                                        </button>
                                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                                            Edit Amenity
                                                        </div>
                                                    </div>

                                                    <!-- Delete Icon with Tooltip & Custom Modal -->
                                                    <div class="relative flex items-center group/tooltip">
                                                        <button @click="openDeleteModal('{{ route('amenities.destroy', $amenity->id) }}', '{{ addslashes($amenity->name) }}')" 
                                                                class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors">
                                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                        </button>
                                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover/tooltip:opacity-100 transition-opacity whitespace-nowrap pointer-events-none z-10">
                                                            Delete Amenity
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 flex flex-col items-center flex-1 justify-center">
                            <i data-lucide="sparkles" class="w-12 h-12 text-orange-200 mb-4"></i>
                            <h3 class="text-xl font-semibold p-text mb-2 p-serif">No amenities yet</h3>
                            <p class="text-gray-500 text-sm">Add your first amenity using the form.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- AlpineJS Modal for Edit -->
        <div x-show="isEditModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isEditModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isEditModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full p-8" @click.away="closeEditModal()">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl p-serif font-bold p-text flex items-center">
                            <i data-lucide="edit" class="w-5 h-5 mr-2 text-[#e06828]"></i> Edit Amenity
                        </h3>
                        <button @click="closeEditModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <form :action="editFormAction" method="POST" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="p-label block mb-2">Amenity Name</label>
                            <input type="text" name="name" x-model="editName" required class="p-input">
                        </div>
                        <div>
                            <label class="p-label block mb-2">Price</label>
                            <input type="number" name="price" x-model="editPrice" required min="0" step="0.01" class="p-input">
                        </div>
                        <div>
                            <label class="p-label block mb-2">Pricing Type</label>
                            <select name="pricing_type" x-model="editPricingType" class="p-input" required>
                                <option value="fixed">Fixed</option>
                                <option value="per_person">Per Person</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label block mb-2">Description (Optional)</label>
                            <textarea name="description" x-model="editDescription" class="p-input" rows="3"></textarea>
                        </div>
                        <div class="flex items-center gap-3">
                            <label class="flex items-center gap-2 p-label">
                                <input type="checkbox" name="status" x-model="editStatus" value="1" class="p-checkbox" />
                                Active
                            </label>
                        </div>
                        <div class="flex space-x-3 pt-4 border-t border-orange-100">
                            <button type="button" @click="closeEditModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 p-btn">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- AlpineJS Modal for Delete Confirmation -->
        <div x-show="isDeleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isDeleteModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isDeleteModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full p-8 text-center" @click.away="closeDeleteModal()">
                    
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                        <i data-lucide="alert-triangle" class="h-8 w-8 text-red-600"></i>
                    </div>
                    
                    <h3 class="text-xl font-bold p-text mb-2 p-serif">Confirm Deletion</h3>
                    <p class="text-gray-500 mb-6">Are you sure you want to delete <span class="font-bold text-gray-800" x-text="deleteAmenityName"></span>? This action cannot be undone.</p>
                    
                    <form :action="deleteFormAction" method="POST" class="flex space-x-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="closeDeleteModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-colors shadow-lg uppercase text-sm tracking-wider">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine Component Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('amenitiesManager', () => ({
                isEditModalOpen: false,
                isDeleteModalOpen: false,
                editFormAction: '',
                editName: '',
                editPrice: 0,
                editPricingType: 'fixed',
                editStatus: true,
                editDescription: '',
                deleteFormAction: '',
                deleteAmenityName: '',

                openEditModal(id, name, price, pricingType, status, description) {
                    this.editFormAction = `/amenities/${id}`;
                    this.editName = name;
                    this.editPrice = price;
                    this.editPricingType = pricingType;
                    this.editStatus = !!status;
                    this.editDescription = description;
                    this.isEditModalOpen = true;
                },

                closeEditModal() {
                    this.isEditModalOpen = false;
                },

                openDeleteModal(actionUrl, name) {
                    this.deleteFormAction = actionUrl;
                    this.deleteAmenityName = name;
                    this.isDeleteModalOpen = true;
                },

                closeDeleteModal() {
                    this.isDeleteModalOpen = false;
                }
            }));
        });
    </script>
</x-admin-layout>