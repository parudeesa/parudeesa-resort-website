<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Instagram Reels Management') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="reelManagement()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold p-serif text-[#3e2010]">Reels Gallery</h1>
                    <p class="text-gray-500 mt-1 italic">Curate the best moments for your homepage.</p>
                </div>
                <button @click="openCreateModal()" class="p-btn flex items-center gap-2 px-6 py-3">
                    <i data-lucide="plus" class="w-5 h-5"></i>
                    Add New Reel
                </button>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center animate-fade-in">
                    <i data-lucide="check-circle" class="w-5 h-5 mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Reels Grid (Sortable) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6" id="reels-grid">
                @foreach($reels as $reel)
                    <div class="reel-item p-card group relative" data-id="{{ $reel->id }}">
                        <!-- Thumbnail Preview -->
                        <div class="aspect-[9/16] rounded-xl overflow-hidden mb-4 relative bg-gray-100">
                            @if($reel->thumbnail)
                                <img src="{{ asset('storage/' . $reel->thumbnail) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                    <i data-lucide="image" class="w-12 h-12 mb-2"></i>
                                    <span class="text-xs uppercase font-bold tracking-widest">No Preview</span>
                                </div>
                            @endif
                            
                            <!-- Overlay Actions -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
                                <button @click="openEditModal({{ json_encode($reel) }})" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-700 hover:bg-[#e06828] hover:text-white transition-all shadow-lg">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </button>
                                <form action="{{ route('admin.reels.destroy', $reel) }}" method="POST" onsubmit="return confirm('Delete this reel?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-lg">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Order Badge -->
                            <div class="absolute top-3 left-3 w-8 h-8 bg-white/90 backdrop-blur rounded-lg flex items-center justify-center text-xs font-bold text-[#3e2010] shadow-sm">
                                #{{ $loop->iteration }}
                            </div>
                        </div>

                        <div class="px-1">
                            <h3 class="font-bold text-gray-800 truncate mb-1">{{ $reel->title }}</h3>
                            <a href="{{ $reel->instagram_url }}" target="_blank" class="text-xs text-[#e06828] hover:underline flex items-center gap-1">
                                <i data-lucide="instagram" class="w-3 h-3"></i>
                                View on Instagram
                            </a>
                        </div>

                        <!-- Drag Handle -->
                        <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity cursor-move p-2 bg-white/90 backdrop-blur rounded-lg shadow-sm handle">
                            <i data-lucide="grip-vertical" class="w-4 h-4 text-gray-400"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Modal for Add/Edit -->
            <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity" x-cloak>
                <div @click.away="modalOpen = false" class="bg-white rounded-3xl w-full max-w-xl max-h-[90vh] overflow-y-auto shadow-2xl animate-scale-in">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold p-serif text-[#3e2010]" x-text="isEdit ? 'Edit Reel' : 'Add New Reel'"></h2>
                            <button @click="modalOpen = false" class="text-gray-400 hover:text-gray-600">
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>

                        <form :action="isEdit ? `/admin/reels/${currentReel.id}` : '{{ route('admin.reels.store') }}'" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <template x-if="isEdit">
                                <input type="hidden" name="_method" value="PATCH">
                            </template>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Reel Title</label>
                                <input type="text" name="title" x-model="currentReel.title" required class="w-full p-input border-gray-100 focus:border-[#e06828] focus:ring-[#e06828]">
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Instagram Reel URL</label>
                                <input type="url" name="instagram_url" x-model="currentReel.instagram_url" required placeholder="https://www.instagram.com/reel/..." class="w-full p-input border-gray-100 focus:border-[#e06828] focus:ring-[#e06828]">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Thumbnail (Poster)</label>
                                    <div class="relative aspect-[9/16] rounded-2xl border-2 border-dashed border-gray-200 hover:border-[#e06828] transition-all overflow-hidden flex items-center justify-center bg-gray-50">
                                        <img x-show="previewUrl" :src="previewUrl" class="w-full h-full object-cover">
                                        <div x-show="!previewUrl" class="text-center text-gray-400">
                                            <i data-lucide="image-plus" class="w-8 h-8 mx-auto mb-1 opacity-50"></i>
                                            <p class="text-[8px] font-bold uppercase">Cover Image</p>
                                        </div>
                                        <input type="file" name="thumbnail" class="absolute inset-0 opacity-0 cursor-pointer" @change="previewImage($event)">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Preview Video (Optional)</label>
                                    <div class="relative aspect-[9/16] rounded-2xl border-2 border-dashed border-gray-200 hover:border-[#e06828] transition-all overflow-hidden flex items-center justify-center bg-gray-50">
                                        <div class="text-center text-gray-400">
                                            <i data-lucide="video" class="w-8 h-8 mx-auto mb-1 opacity-50"></i>
                                            <p class="text-[8px] font-bold uppercase" x-text="currentReel.video ? 'Video Uploaded' : 'Upload MP4'"></p>
                                        </div>
                                        <input type="file" name="video" class="absolute inset-0 opacity-0 cursor-pointer" accept="video/*">
                                    </div>
                                    <p class="text-[9px] text-gray-400 italic">Autoplays on homepage (muted).</p>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-wider text-gray-400">Short Description (Optional)</label>
                                <textarea name="description" x-model="currentReel.description" rows="3" class="w-full p-input border-gray-100 focus:border-[#e06828] focus:ring-[#e06828]"></textarea>
                            </div>

                            <div class="flex items-center gap-4 py-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" x-model="currentReel.is_active" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#e06828]"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-600">Active / Visible</span>
                                </label>
                            </div>

                            <div class="pt-6 border-t border-gray-50">
                                <button type="submit" class="p-btn w-full py-4 text-lg" x-text="isEdit ? 'Update Reel' : 'Save Reel'"></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .p-card {
            background: #fff;
            border-radius: 1.5rem;
            padding: 1.25rem;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 4px 20px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .p-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(224,104,40,0.08);
            border-color: rgba(224,104,40,0.1);
        }
        .p-btn {
            background: linear-gradient(135deg, #3e2010 0%, #2e1408 100%);
            color: #fff;
            font-weight: 700;
            border-radius: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(62,32,16,0.2);
        }
        .p-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(62,32,16,0.3);
            filter: brightness(1.1);
        }
        .p-input {
            background-color: #fcfcfc;
            border: 1px solid #f0f0f0;
            border-radius: 1rem;
            padding: 0.875rem 1.25rem;
            transition: all 0.3s ease;
        }
        .animate-fade-in { animation: fadeIn 0.4s ease-out; }
        .animate-scale-in { animation: scaleIn 0.3s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        [x-cloak] { display: none !important; }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function reelManagement() {
            return {
                modalOpen: false,
                isEdit: false,
                currentReel: {
                    title: '',
                    instagram_url: '',
                    description: '',
                    is_active: true
                },
                previewUrl: null,

                openCreateModal() {
                    this.isEdit = false;
                    this.currentReel = { title: '', instagram_url: '', description: '', is_active: true };
                    this.previewUrl = null;
                    this.modalOpen = true;
                },

                openEditModal(reel) {
                    this.isEdit = true;
                    this.currentReel = { ...reel };
                    this.previewUrl = reel.thumbnail ? `/storage/${reel.thumbnail}` : null;
                    this.modalOpen = true;
                },

                previewImage(event) {
                    const file = event.target.files[0];
                    if (file) {
                        this.previewUrl = URL.createObjectURL(file);
                    }
                },

                init() {
                    const el = document.getElementById('reels-grid');
                    Sortable.create(el, {
                        handle: '.handle',
                        animation: 150,
                        onEnd: () => {
                            const order = Array.from(el.querySelectorAll('.reel-item')).map((item, index) => {
                                return { id: item.dataset.id, order: index + 1 };
                            });
                            
                            fetch('{{ route('admin.reels.update_order') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ order })
                            });
                        }
                    });
                }
            }
        }
    </script>
</x-admin-layout>
