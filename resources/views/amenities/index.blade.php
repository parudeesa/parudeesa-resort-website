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
                    <form action="{{ route('amenities.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="p-label">Amenity Name</label>
                            <input id="name" name="name" type="text" class="p-input mt-1" placeholder="e.g. Infinity Pool" required minlength="3" maxlength="255" />
                        </div>
                        <div>
                            <label class="p-label">Price</label>
                            <input id="price" name="price" type="number" min="0" max="1000000" step="0.01" class="p-input mt-1" placeholder="e.g. 1000" required />
                        </div>
                        <div>
                            <label class="p-label">Pricing Type</label>
                            <select id="pricing_type" name="pricing_type" class="p-input mt-1" required>
                                <option value="fixed">Fixed</option>
                                <option value="per_person">Per Person</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label">Property Assignment</label>
                            <select id="property_assignment" name="property_assignment" class="p-input mt-1" required>
                                <option value="both">Both Properties</option>
                                <option value="paradise">Paradise Only</option>
                                <option value="utopia">Utopia Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label">Description (Optional)</label>
                            <textarea id="description" name="description" class="p-input mt-1" rows="3" placeholder="Brief details..." maxlength="2000"></textarea>
                        </div>
                        <div>
                            <label class="p-label">Amenity Image</label>
                            <div class="mt-1 flex items-center gap-4">
                                <div id="add_preview" class="w-16 h-16 rounded-lg border border-orange-100 overflow-hidden hidden bg-orange-50"></div>
                                <input id="image" name="image" type="file" class="p-input mt-1" accept="image/*" onchange="previewImage(this, 'add_preview')" />
                            </div>
                        </div>
                        <div>
                            <label class="p-label">Condition Note (Optional)</label>
                            <input id="condition_note" name="condition_note" type="text" class="p-input mt-1" placeholder="e.g. ₹1000 / person (below 5 people)" maxlength="255" />
                        </div>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 p-label">
                                <input id="status" name="status" type="checkbox" value="1" checked class="p-checkbox" />
                                Active
                            </label>
                            <label class="flex items-center gap-2 p-label">
                                <input id="is_premium" name="is_premium" type="checkbox" value="1" class="p-checkbox" />
                                Premium
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
                                        <th class="px-6 py-4 text-left p-label rounded-tl-lg">Amenity</th>
                                        <th class="px-6 py-4 text-left p-label">Price</th>
                                        <th class="px-6 py-4 text-left p-label">Pricing Type</th>
                                        <th class="px-6 py-4 text-left p-label">Details</th>
                                        <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                                    @foreach($amenities as $amenity)
                                        <tr class="hover:bg-orange-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-lg border border-orange-100 overflow-hidden bg-orange-50 flex-shrink-0">
                                                        @if($amenity->image)
                                                            <img src="{{ asset($amenity->image) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-orange-200">
                                                                <i data-lucide="image" class="w-5 h-5"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="font-bold p-text text-md">{{ $amenity->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-700">₹{{ number_format($amenity->price, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold" style="background:rgba(250,135,62,.1);color:#b45309">{{ ucfirst(str_replace('_', ' ', $amenity->pricing_type)) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600 truncate max-w-xs">{{ $amenity->description ?: '—' }}</div>
                                                @if($amenity->condition_note)
                                                    <div class="text-[10px] text-orange-500 font-bold uppercase mt-1 italic">{{ $amenity->condition_note }}</div>
                                                @endif
                                                @if($amenity->is_premium)
                                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-bold mt-1 bg-yellow-100 text-yellow-800 uppercase tracking-tighter">Premium</span>
                                                @endif
                                                <div class="mt-1 flex gap-1">
                                                    @if($amenity->property_assignment === 'both' || $amenity->property_assignment === 'paradise')
                                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[9px] font-bold bg-blue-50 text-blue-700 uppercase">Paradise</span>
                                                    @endif
                                                    @if($amenity->property_assignment === 'both' || $amenity->property_assignment === 'utopia')
                                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[9px] font-bold bg-purple-50 text-purple-700 uppercase">Utopia</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex justify-end space-x-2">
                                                    <!-- Edit Icon with Tooltip -->
                                                    <div class="relative flex items-center group/tooltip">
                                                        <button @click="openEditModal({{ json_encode($amenity) }})" 
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

                    <form :action="editFormAction" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="p-label block mb-2">Amenity Name</label>
                            <input type="text" name="name" x-model="editName" required minlength="3" maxlength="255" class="p-input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-2">Price</label>
                                <input type="number" name="price" x-model="editPrice" required min="0" max="1000000" step="0.01" class="p-input">
                            </div>
                            <div>
                                <label class="p-label block mb-2">Pricing Type</label>
                                <select name="pricing_type" x-model="editPricingType" class="p-input" required>
                                    <option value="fixed">Fixed</option>
                                    <option value="per_person">Per Person</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="p-label block mb-2">Property Assignment</label>
                            <select name="property_assignment" x-model="editPropertyAssignment" class="p-input" required>
                                <option value="both">Both Properties</option>
                                <option value="paradise">Paradise Only</option>
                                <option value="utopia">Utopia Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label block mb-2">Description (Optional)</label>
                            <textarea name="description" x-model="editDescription" class="p-input" rows="3" maxlength="2000"></textarea>
                        </div>
                        <div>
                            <label class="p-label block mb-2">Amenity Image</label>
                            <div class="flex items-center gap-4">
                                <div id="edit_preview" class="w-20 h-20 rounded-xl border border-orange-100 overflow-hidden bg-orange-50">
                                    <template x-if="editImage">
                                        <img :src="`{{ asset('') }}${editImage}`" class="w-full h-full object-cover">
                                    </template>
                                </div>
                                <input type="file" name="image" class="p-input text-xs" accept="image/*" onchange="previewImage(this, 'edit_preview_img')">
                            </div>
                            <div id="edit_preview_img" class="mt-2 h-32 rounded-xl border border-orange-100 overflow-hidden hidden"></div>
                        </div>
                        <div>
                            <label class="p-label block mb-2">Condition Note (Optional)</label>
                            <input type="text" name="condition_note" x-model="editConditionNote" maxlength="255" class="p-input">
                        </div>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 p-label">
                                <input type="checkbox" name="status" x-model="editStatus" value="1" class="p-checkbox" />
                                Active
                            </label>
                            <label class="flex items-center gap-2 p-label">
                                <input type="checkbox" name="is_premium" x-model="editIsPremium" value="1" class="p-checkbox" />
                                Premium
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
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

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
                editIsPremium: false,
                editImage: '',
                editConditionNote: '',
                editPropertyAssignment: 'both',
                deleteFormAction: '',
                deleteAmenityName: '',

                openEditModal(amenity) {
                    this.editFormAction = `/amenities/${amenity.id}`;
                    this.editName = amenity.name;
                    this.editPrice = amenity.price;
                    this.editPricingType = amenity.pricing_type;
                    this.editStatus = !!amenity.status;
                    this.editDescription = amenity.description || '';
                    this.editIsPremium = !!amenity.is_premium;
                    this.editImage = amenity.image || '';
                    this.editConditionNote = amenity.condition_note || '';
                    this.editPropertyAssignment = amenity.property_assignment || 'both';
                    this.isEditModalOpen = true;
                    
                    // Reset preview
                    setTimeout(() => {
                        const preview = document.getElementById('edit_preview_img');
                        if (preview) {
                            preview.innerHTML = '';
                            preview.classList.add('hidden');
                        }
                        lucide.createIcons();
                    }, 50);
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