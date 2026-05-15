<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="p-serif font-semibold text-2xl text-[#e06828]">
                Events Page CMS Manager
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('events') }}" target="_blank" class="p-btn bg-white !text-[#e06828] border border-[#e06828] !shadow-none hover:bg-orange-50 flex items-center">
                    <i data-lucide="external-link" class="w-4 h-4 mr-2"></i> View Page
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6" x-data="{ tab: 'hero' }">
        
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm mb-6" role="alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-2 p-1 bg-orange-50/50 rounded-2xl border border-orange-100 overflow-x-auto">
            <button @click="tab = 'hero'" :class="tab === 'hero' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Hero</button>
            <button @click="tab = 'cards'" :class="tab === 'cards' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Event Cards</button>
            <button @click="tab = 'pricing'" :class="tab === 'pricing' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Pricing</button>
            <button @click="tab = 'amenities'" :class="tab === 'amenities' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Amenities</button>
            <button @click="tab = 'gallery'" :class="tab === 'gallery' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Gallery</button>
            <button @click="tab = 'steps'" :class="tab === 'steps' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">Steps</button>
            <button @click="tab = 'seo'" :class="tab === 'seo' ? 'bg-white shadow-sm text-[#e06828] font-bold' : 'text-gray-500 hover:text-gray-700'" class="px-6 py-2.5 rounded-xl transition-all text-sm uppercase tracking-wider">SEO</button>
        </div>

        <!-- HERO TAB -->
        <div x-show="tab === 'hero'" class="p-card p-8 space-y-6">
            <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Hero Section Settings</h3>
            
            <form action="{{ route('admin.events-manager.hero.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Section Status</label>
                            <div class="flex items-center mt-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="status" class="sr-only peer" {{ ($hero['status'] ?? true) ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#e06828]"></div>
                                    <span class="ms-3 text-sm font-medium text-gray-700">Visible on Page</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label class="p-label">Eyebrow Text</label>
                            <input type="text" name="eyebrow" value="{{ $hero['eyebrow'] ?? '' }}" class="p-input">
                        </div>
                        <div>
                            <label class="p-label">Title (HTML allowed)</label>
                            <input type="text" name="title" value="{{ $hero['title'] ?? '' }}" class="p-input">
                        </div>
                        <div>
                            <label class="p-label">Subtitle</label>
                            <textarea name="subtitle" rows="3" class="p-input">{{ $hero['subtitle'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Background Media</label>
                            <input type="file" name="image" class="p-input">
                            @if($hero['image'] ?? '')
                            <div class="mt-2 relative group">
                                <img src="{{ $hero['image'] }}" class="w-full h-40 object-cover rounded-xl border border-orange-100">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                    <span class="text-white text-xs font-bold uppercase tracking-widest">Current Image</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label">CTA 1 Text</label>
                                <input type="text" name="cta_1_text" value="{{ $hero['cta_1_text'] ?? '' }}" class="p-input">
                            </div>
                            <div>
                                <label class="p-label">CTA 1 Link</label>
                                <input type="text" name="cta_1_link" value="{{ $hero['cta_1_link'] ?? '' }}" class="p-input">
                            </div>
                            <div>
                                <label class="p-label">CTA 2 Text</label>
                                <input type="text" name="cta_2_text" value="{{ $hero['cta_2_text'] ?? '' }}" class="p-input">
                            </div>
                            <div>
                                <label class="p-label">CTA 2 Link</label>
                                <input type="text" name="cta_2_link" value="{{ $hero['cta_2_link'] ?? '' }}" class="p-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-4 border-t border-orange-100">
                    <button type="submit" class="p-btn">Update Hero Section</button>
                </div>
            </form>
        </div>

        <!-- CARDS TAB -->
        <div x-show="tab === 'cards'" class="space-y-6">
            <div class="p-card p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Events We Host Cards</h3>
                    <button @click="$dispatch('open-modal', 'add-card')" class="p-btn text-xs">+ Add New Card</button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4" id="cards-sortable">
                    @foreach($cards as $card)
                    <div class="p-4 bg-white rounded-2xl border border-orange-100 shadow-sm relative group cursor-move" data-id="{{ $card->id }}">
                        <div class="text-3xl mb-3 text-center">{{ $card->icon }}</div>
                        <h4 class="text-xs font-bold text-center text-gray-700 truncate">{{ $card->title }}</h4>
                        
                        <div class="absolute top-1 right-1 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="p-1 bg-red-50 text-red-600 rounded-md hover:bg-red-100" onclick="confirmDeleteCard({{ $card->id }})">
                                <i data-lucide="trash-2" class="w-3 h-3"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <p class="mt-4 text-xs text-gray-400 italic flex items-center">
                    <i data-lucide="info" class="w-3 h-3 mr-1"></i> Drag and drop cards to reorder them on the live page.
                </p>
            </div>
        </div>

        <!-- PRICING TAB -->
        <div x-show="tab === 'pricing'" class="p-card p-8 space-y-6">
            <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Custom Pricing Section Settings</h3>
            
            <form action="{{ route('admin.events-manager.pricing.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Label</label>
                            <input type="text" name="label" value="{{ $pricing['label'] ?? '' }}" class="p-input">
                        </div>
                        <div>
                            <label class="p-label">Title (HTML allowed)</label>
                            <input type="text" name="title" value="{{ $pricing['title'] ?? '' }}" class="p-input">
                        </div>
                        <div>
                            <label class="p-label">Subtitle</label>
                            <textarea name="subtitle" rows="3" class="p-input">{{ $pricing['subtitle'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="p-label">CTA Button Text</label>
                            <input type="text" name="cta_text" value="{{ $pricing['cta_text'] ?? '' }}" class="p-input">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Event Setup Image</label>
                            <input type="file" name="image" class="p-input">
                            @if($pricing['image'] ?? '')
                            <img src="{{ $pricing['image'] }}" class="mt-2 w-full h-32 object-cover rounded-xl">
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label">Badge Label</label>
                                <input type="text" name="badge_label" value="{{ $pricing['badge_label'] ?? '' }}" class="p-input">
                            </div>
                            <div>
                                <label class="p-label">Badge Value</label>
                                <input type="text" name="badge_value" value="{{ $pricing['badge_value'] ?? '' }}" class="p-input">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-4 border-t border-orange-100">
                    <button type="submit" class="p-btn">Update Pricing Section</button>
                </div>
            </form>

            <div class="mt-8 border-t border-orange-100 pt-8">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="p-serif text-xl font-bold text-[#3e2010]">Pricing Features Grid</h4>
                    <button @click="$dispatch('open-modal', 'add-feature')" class="p-btn text-[10px] py-1">+ Add Feature</button>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="features-sortable">
                    @foreach($pricingFeatures as $feature)
                    <div class="p-3 bg-white rounded-xl border border-orange-100 flex items-center justify-between group cursor-move" data-id="{{ $feature->id }}">
                        <div class="flex items-center gap-3">
                            <i class="bi {{ $feature->icon }} text-[#e06828]"></i>
                            <span class="text-xs font-medium">{{ $feature->text }}</span>
                        </div>
                        <button class="p-1 text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity" onclick="confirmDeleteFeature({{ $feature->id }})">
                            <i data-lucide="x" class="w-3 h-3"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- AMENITIES TAB -->
        <div x-show="tab === 'amenities'" class="space-y-6">
            <div class="p-card p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Amenities & Experiences Carousel</h3>
                    <button @click="$dispatch('open-modal', 'add-amenity')" class="p-btn text-xs">+ Add Amenity</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="amenities-sortable">
                    @foreach($amenities as $amenity)
                    <div class="p-6 bg-white rounded-2xl border border-orange-100 shadow-sm relative group cursor-move" data-id="{{ $amenity->id }}">
                        <div class="flex items-start gap-4">
                            <div class="text-3xl">{{ $amenity->icon }}</div>
                            <div class="flex-1">
                                <h4 class="font-bold text-gray-800">{{ $amenity->title }}</h4>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $amenity->description }}</p>
                            </div>
                        </div>
                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100" onclick="confirmDeleteAmenity({{ $amenity->id }})">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- GALLERY TAB -->
        <div x-show="tab === 'gallery'" class="space-y-6">
            <div class="p-card p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Event Gallery</h3>
                    <form action="{{ route('admin.events-manager.gallery.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
                        @csrf
                        <input type="file" name="images[]" multiple class="p-input text-xs" required>
                        <button type="submit" class="p-btn text-xs">Upload Images</button>
                    </form>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" id="gallery-sortable">
                    @foreach($gallery as $item)
                    <div class="aspect-square rounded-xl overflow-hidden relative group cursor-move border border-orange-100" data-id="{{ $item->id }}">
                        <img src="{{ $item->image }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                            <button class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600" onclick="confirmDeleteGallery({{ $item->id }})">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @if($item->category)
                        <div class="absolute bottom-1 left-1 bg-white/90 px-2 py-0.5 rounded text-[10px] font-bold text-[#e06828]">{{ $item->category }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- STEPS TAB -->
        <div x-show="tab === 'steps'" class="space-y-6">
            <div class="p-card p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Effortless Journey Steps</h3>
                    <button @click="$dispatch('open-modal', 'add-step')" class="p-btn text-xs">+ Add Step</button>
                </div>

                <div class="space-y-4" id="steps-sortable">
                    @foreach($steps as $step)
                    <div class="p-4 bg-white rounded-2xl border border-orange-100 shadow-sm flex items-center gap-6 group cursor-move" data-id="{{ $step->id }}">
                        <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828] font-serif text-xl font-bold">
                            {{ str_pad($step->step_number ?? $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-800">{{ $step->title }}</h4>
                            <p class="text-xs text-gray-500">{{ $step->description }}</p>
                        </div>
                        <button class="p-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 opacity-0 group-hover:opacity-100 transition-opacity" onclick="confirmDeleteStep({{ $step->id }})">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- SEO TAB -->
        <div x-show="tab === 'seo'" class="p-card p-8 space-y-6">
            <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Search Engine Optimization (SEO)</h3>
            
            <form action="{{ route('admin.events-manager.seo.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Meta Title</label>
                            <input type="text" name="title" value="{{ $seo['title'] ?? '' }}" class="p-input">
                        </div>
                        <div>
                            <label class="p-label">Meta Description</label>
                            <textarea name="description" rows="4" class="p-input">{{ $seo['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="p-label">Social Share Image (OG Image)</label>
                            <input type="file" name="og_image" class="p-input">
                            @if($seo['og_image'] ?? '')
                            <img src="{{ $seo['og_image'] }}" class="mt-2 w-full h-32 object-cover rounded-xl border">
                            @endif
                        </div>
                        <div>
                            <label class="p-label">Schema Markup / Scripts (Head)</label>
                            <textarea name="schema_markup" rows="3" class="p-input font-mono text-xs">{{ $seo['schema_markup'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end pt-4 border-t border-orange-100">
                    <button type="submit" class="p-btn">Update SEO Settings</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modals -->
    <x-modal name="add-card" focusable>
        <form method="post" action="{{ route('admin.events-manager.cards.store') }}" class="p-8">
            @csrf
            <h2 class="p-serif text-2xl font-bold text-[#e06828] mb-6">Add New Event Card</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="p-label">Title</label>
                    <input type="text" name="title" class="p-input" placeholder="e.g. Baby Shower" required>
                </div>
                <div>
                    <label class="p-label">Icon (Emoji or Icon Class)</label>
                    <input type="text" name="icon" class="p-input" placeholder="e.g. 👶 or bi-star">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-6 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors uppercase font-bold text-xs">Cancel</button>
                <button type="submit" class="p-btn">Save Card</button>
            </div>
        </form>
    </x-modal>

    <x-modal name="add-amenity" focusable>
        <form method="post" action="{{ route('admin.events-manager.amenities.store') }}" class="p-8">
            @csrf
            <h2 class="p-serif text-2xl font-bold text-[#e06828] mb-6">Add New Amenity</h2>
            <div class="space-y-4">
                <div>
                    <label class="p-label">Title</label>
                    <input type="text" name="title" class="p-input" required>
                </div>
                <div>
                    <label class="p-label">Icon (Emoji)</label>
                    <input type="text" name="icon" class="p-input">
                </div>
                <div>
                    <label class="p-label">Description</label>
                    <textarea name="description" rows="3" class="p-input"></textarea>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="p-btn !bg-gray-100 !text-gray-600 !shadow-none">Cancel</button>
                <button type="submit" class="p-btn">Save Amenity</button>
            </div>
        </form>
    </x-modal>

    <x-modal name="add-step" focusable>
        <form method="post" action="{{ route('admin.events-manager.steps.store') }}" class="p-8">
            @csrf
            <h2 class="p-serif text-2xl font-bold text-[#e06828] mb-6">Add Journey Step</h2>
            <div class="space-y-4">
                <div>
                    <label class="p-label">Step Number</label>
                    <input type="number" name="step_number" class="p-input">
                </div>
                <div>
                    <label class="p-label">Title</label>
                    <input type="text" name="title" class="p-input" required>
                </div>
                <div>
                    <label class="p-label">Description</label>
                    <textarea name="description" rows="3" class="p-input"></textarea>
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="p-btn !bg-gray-100 !text-gray-600 !shadow-none">Cancel</button>
                <button type="submit" class="p-btn">Save Step</button>
            </div>
        </form>
    </x-modal>

    <x-modal name="add-feature" focusable>
        <form method="post" action="{{ route('admin.events-manager.features.store') }}" class="p-8">
            @csrf
            <h2 class="p-serif text-2xl font-bold text-[#e06828] mb-6">Add Pricing Feature</h2>
            <div class="space-y-4">
                <div>
                    <label class="p-label">Text</label>
                    <input type="text" name="text" class="p-input" required>
                </div>
                <div>
                    <label class="p-label">Icon Class (Bootstrap Icons)</label>
                    <input type="text" name="icon" class="p-input" placeholder="bi-check2-circle">
                </div>
            </div>
            <div class="mt-8 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="p-btn !bg-gray-100 !text-gray-600 !shadow-none">Cancel</button>
                <button type="submit" class="p-btn">Save Feature</button>
            </div>
        </form>
    </x-modal>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortables = [
                { id: 'cards-sortable', type: 'card' },
                { id: 'amenities-sortable', type: 'amenity' },
                { id: 'gallery-sortable', type: 'gallery' },
                { id: 'steps-sortable', type: 'step' },
                { id: 'features-sortable', type: 'feature' }
            ];

            sortables.forEach(s => {
                const el = document.getElementById(s.id);
                if (el) {
                    new Sortable(el, {
                        animation: 150,
                        ghostClass: 'opacity-50',
                        onEnd: function() {
                            const ids = Array.from(el.querySelectorAll('[data-id]')).map(item => item.dataset.id);
                            updateOrder(s.type, ids);
                        }
                    });
                }
            });
        });

        function updateOrder(type, ids) {
            fetch("{{ route('admin.events-manager.update_order') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ type, ids })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // Show small toast or notification
                }
            });
        }

        function confirmDeleteCard(id) {
            if(confirm('Are you sure you want to delete this event card?')) {
                submitDelete(`/admin/events-manager/cards/${id}`);
            }
        }
        function confirmDeleteAmenity(id) {
            if(confirm('Are you sure you want to delete this amenity?')) {
                submitDelete(`/admin/events-manager/amenities/${id}`);
            }
        }
        function confirmDeleteGallery(id) {
            if(confirm('Are you sure you want to delete this image?')) {
                submitDelete(`/admin/events-manager/gallery/${id}`);
            }
        }
        function confirmDeleteStep(id) {
            if(confirm('Are you sure you want to delete this journey step?')) {
                submitDelete(`/admin/events-manager/steps/${id}`);
            }
        }
        function confirmDeleteFeature(id) {
            if(confirm('Are you sure you want to delete this feature?')) {
                submitDelete(`/admin/events-manager/features/${id}`);
            }
        }

        function submitDelete(url) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</x-admin-layout>
