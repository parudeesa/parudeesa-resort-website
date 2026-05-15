<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Homepage Management') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="homepageManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                <div>
                    <h1 class="text-4xl font-bold p-serif text-[#e06828]">Homepage Sections</h1>
                    <p class="text-gray-500 text-lg mt-2">Click on a section to manage its content, images, and items.</p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border-l-4 border-green-500 text-green-700 p-6 rounded-2xl shadow-sm flex items-center justify-between animate-fade-in">
                    <div class="flex items-center">
                        <i data-lucide="check-circle" class="w-6 h-6 mr-4 text-green-500"></i>
                        <span class="font-bold text-lg">{{ session('success') }}</span>
                    </div>
                    <button @click="$el.parentElement.remove()" class="text-green-500 hover:text-green-700">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>
                </div>
            @endif

            <!-- Section Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Hero Section Card -->
                <div @click="openModal('hero')" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-orange-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="layout" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Hero Section</h3>
                        <p class="text-gray-500 text-sm">Main headline, background image, and primary call-to-actions.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Section</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </div>

                <!-- Featured Properties Card -->
                <a href="{{ route('properties.index') }}" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="home" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Featured Properties</h3>
                        <p class="text-gray-500 text-sm">Manage the properties shown on the homepage and their details.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Section</span>
                        <i data-lucide="external-link" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </a>

                <!-- Amenities Card -->
                <div @click="activeView = 'amenities'" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="sparkles" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Amenities</h3>
                        <p class="text-gray-500 text-sm">Key resort experiences like Infinity Pool, Boating, etc.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Items</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </div>

                <!-- Events Banner Card -->
                <div @click="openModal('events')" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="calendar" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Events Banner</h3>
                        <p class="text-gray-500 text-sm">Highlight celebrations and link to the events inquiry page.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Section</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </div>

                <!-- Reviews Card -->
                <div @click="openModal('reviews')" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="message-square" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Guest Reviews</h3>
                        <p class="text-gray-500 text-sm">Manage testimonials and Google Reviews badge info.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Section</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div @click="openModal('contact')" class="p-card group cursor-pointer hover:shadow-2xl transition-all duration-500 overflow-hidden relative">
                    <div class="p-8">
                        <div class="h-16 w-16 rounded-2xl bg-orange-100 flex items-center justify-center text-[#e06828] mb-6 group-hover:scale-110 transition-transform duration-500">
                            <i data-lucide="phone" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-2">Contact Info</h3>
                        <p class="text-gray-500 text-sm">Address, phone numbers, email, and Google Maps embed.</p>
                    </div>
                    <div class="px-8 py-4 bg-orange-50/50 border-t border-orange-100 flex justify-between items-center">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#e06828]">Manage Section</span>
                        <i data-lucide="chevron-right" class="w-4 h-4 text-[#e06828]"></i>
                    </div>
                </div>

            </div>

            <!-- ████████████████████ AMENITIES VIEW ████████████████████ -->
            <template x-if="activeView === 'amenities'">
                <div class="mt-12 animate-fade-in space-y-8">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <button @click="activeView = 'dashboard'" class="h-10 w-10 rounded-full bg-white border border-orange-100 flex items-center justify-center text-[#e06828] hover:bg-orange-50 transition-colors shadow-sm">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </button>
                            <h2 class="text-3xl font-bold p-serif text-[#3e2010]">Resort Amenities</h2>
                        </div>
                        <button @click="openAmenityModal()" class="p-btn text-sm flex items-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i> Add New Amenity
                        </button>
                    </div>

                    <div class="p-card p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="amenities-list">
                            @foreach($amenities as $amenity)
                            <div class="relative group p-4 border border-orange-100 rounded-2xl bg-white hover:border-[#e06828] transition-all" data-id="{{ $amenity->id }}">
                                <div class="aspect-video rounded-xl overflow-hidden mb-4 relative">
                                    <img src="{{ asset($amenity->image) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                        <button @click="openAmenityModal({{ json_encode($amenity) }})" class="h-10 w-10 rounded-full bg-white text-[#e06828] flex items-center justify-center hover:scale-110 transition-transform">
                                            <i data-lucide="edit-2" class="w-5 h-5"></i>
                                        </button>
                                        <form action="{{ route('admin.homepage-manager.amenities.delete', $amenity) }}" method="POST" onsubmit="return confirm('Delete this amenity?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="h-10 w-10 rounded-full bg-white text-red-500 flex items-center justify-center hover:scale-110 transition-transform">
                                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <h4 class="font-bold text-[#3e2010]">{{ $amenity->title }}</h4>
                                <div class="mt-2 flex justify-between items-center">
                                    <span class="text-xs font-bold uppercase text-orange-300">Order: {{ $amenity->order }}</span>
                                    <div class="cursor-move text-gray-300 hover:text-gray-600">
                                        <i data-lucide="grip-vertical" class="w-5 h-5"></i>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </template>

        </div>

        <!-- ████████████████████ MODALS ████████████████████ -->
        
        <!-- SECTION SETTINGS MODAL -->
        <div x-show="modal.open" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="modal.open = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
                
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-2xl w-full p-8 overflow-hidden animate-fade-in">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold p-serif text-[#3e2010]" x-text="modal.title">Section Settings</h3>
                        <button @click="modal.open = false" class="text-gray-400 hover:text-[#e06828] transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <form action="{{ route('admin.homepage-manager.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6 max-h-[60vh] overflow-y-auto px-2 custom-scrollbar">
                            <template x-for="setting in modal.settings" :key="setting.key">
                                <div class="space-y-2">
                                    <label class="p-label" x-text="setting.label"></label>
                                    
                                    <template x-if="setting.type === 'text'">
                                        <input type="text" :name="setting.key" :value="setting.value" class="p-input">
                                    </template>
                                    
                                    <template x-if="setting.type === 'textarea'">
                                        <textarea :name="setting.key" x-text="setting.value" rows="4" class="p-input"></textarea>
                                    </template>
                                    
                                    <template x-if="setting.type === 'image'">
                                        <div class="space-y-4">
                                            <div class="relative aspect-video rounded-2xl border-2 border-dashed border-orange-100 bg-orange-50/20 flex items-center justify-center overflow-hidden group cursor-pointer">
                                                <img :id="'preview-' + setting.key" :src="setting.value_url" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                    <span class="px-4 py-2 bg-white rounded-lg text-xs font-bold uppercase tracking-wider text-[#e06828]">Change Image</span>
                                                </div>
                                                <input type="file" :name="setting.key" class="absolute inset-0 opacity-0 cursor-pointer" @change="previewFile($event, 'preview-' + setting.key)">
                                            </div>
                                            <p class="text-[10px] text-gray-400 italic">Current path: <span x-text="setting.value"></span></p>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <div class="mt-10 pt-6 border-t border-orange-50 flex justify-end gap-4">
                            <button type="button" @click="modal.open = false" class="px-6 py-3 text-gray-500 font-bold uppercase tracking-wider text-sm">Cancel</button>
                            <button type="submit" class="p-btn px-8">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- AMENITY MODAL -->
        <div x-show="amenityModal.open" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="amenityModal.open = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"></div>
                
                <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 overflow-hidden animate-fade-in">
                    <h3 class="text-2xl font-bold p-serif text-[#3e2010] mb-8" x-text="amenityModal.isEdit ? 'Edit Amenity' : 'Add New Amenity'"></h3>

                    <form :action="amenityModal.isEdit ? '/admin/homepage-manager/amenities/' + amenityModal.data.id : '{{ route('admin.homepage-manager.amenities.store') }}'" method="POST" enctype="multipart/form-data">
                        @csrf
                        <template x-if="amenityModal.isEdit">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>
                        
                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="p-label">Title</label>
                                <input type="text" name="title" x-model="amenityModal.data.title" class="p-input" required>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="p-label">Image</label>
                                <div class="relative aspect-video rounded-2xl border-2 border-dashed border-orange-100 bg-orange-50/20 flex items-center justify-center overflow-hidden group cursor-pointer">
                                    <img id="amenity-preview" :src="amenityModal.data.image_url || 'https://via.placeholder.com/600x400?text=Upload+Image'" class="w-full h-full object-cover">
                                    <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" @change="previewFile($event, 'amenity-preview')">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-orange-50 flex justify-end gap-4">
                            <button type="button" @click="amenityModal.open = false" class="px-6 py-3 text-gray-500 font-bold uppercase tracking-wider text-sm">Cancel</button>
                            <button type="submit" class="p-btn px-8" x-text="amenityModal.isEdit ? 'Update' : 'Create'"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function homepageManager() {
            return {
                activeView: 'dashboard',
                allSettings: @json($settings),
                modal: {
                    open: false,
                    title: '',
                    group: '',
                    settings: []
                },
                amenityModal: {
                    open: false,
                    isEdit: false,
                    data: {}
                },

                openModal(group) {
                    const groupData = this.allSettings[group] || this.allSettings['home_' + group];
                    if (!groupData) return;

                    this.modal.group = group;
                    this.modal.title = group.charAt(0).toUpperCase() + group.slice(1).replace('_', ' ') + ' Settings';
                    this.modal.settings = groupData.map(s => ({
                        key: s.key,
                        label: s.key.replace('home_', '').replace('contact_', '').replace('_', ' ').replace('_', ' '),
                        value: s.value,
                        value_url: s.type === 'image' ? (s.value.startsWith('http') ? s.value : '/' + s.value) : '',
                        type: s.type
                    }));
                    this.modal.open = true;
                    this.$nextTick(() => lucide.createIcons());
                },

                openAmenityModal(amenity = null) {
                    this.amenityModal.isEdit = !!amenity;
                    this.amenityModal.data = amenity ? {
                        ...amenity,
                        image_url: '/' + amenity.image
                    } : { title: '', image: '', image_url: '' };
                    this.amenityModal.open = true;
                },

                getSettingValue(key) {
                    const group = key.split('_')[1];
                    const fullGroup = this.allSettings[group] || this.allSettings['home_' + group];
                    if (!fullGroup) return '';
                    const setting = fullGroup.find(s => s.key === key);
                    return setting ? setting.value : '';
                },

                getSettingImageUrl(key) {
                    const val = this.getSettingValue(key);
                    if (!val) return '';
                    return val.startsWith('http') ? val : '/' + val;
                },


                previewFile(event, previewId) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            document.getElementById(previewId).src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                init() {
                    this.$watch('activeView', value => {
                        if (value !== 'dashboard') {
                            this.$nextTick(() => {
                                lucide.createIcons();
                                this.initSortable(value);
                            });
                        }
                    });
                },

                initSortable(type) {
                    const el = document.getElementById(type + '-list');
                    if (!el) return;

                    new Sortable(el, {
                        animation: 150,
                        ghostClass: 'bg-orange-50',
                        handle: '.cursor-move',
                        onEnd: (evt) => {
                            const order = Array.from(el.children).map(child => child.dataset.id);
                            let mappedType = type;
                            if (type === 'amenities') mappedType = 'amenity';
                            if (type === 'reviews') mappedType = 'review';
                            this.updateOrder(mappedType, order);
                        }
                    });
                },

                async updateOrder(type, order) {
                    try {
                        const response = await fetch('{{ route('admin.homepage-manager.update_order') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ type, order })
                        });
                        const result = await response.json();
                        if (result.success) {
                            console.log('Order updated');
                        }
                    } catch (error) {
                        console.error('Error updating order:', error);
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(250,135,62,0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(250,135,62,0.2); }
        
        .p-input {
            background-color: #fff !important;
            border-radius: 1rem !important;
            padding: 1rem 1.25rem !important;
            border: 1.5px solid rgba(250,135,62,.15) !important;
            width: 100%;
        }
        .p-input:focus {
            border-color: #e06828 !important;
            box-shadow: 0 0 0 4px rgba(224, 104, 40, 0.1) !important;
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-admin-layout>
