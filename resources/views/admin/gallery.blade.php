<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Gallery Management
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Upload Section -->
        <div class="p-card p-6 sm:p-8">
            <h3 class="p-serif text-xl font-bold mb-6 flex items-center" style="color:#3e2010;">
                <i data-lucide="plus-circle" class="w-5 h-5 mr-2 text-[#e06828]"></i> Add New Media
            </h3>
            
            <form id="uploadForm" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="p-label">Media Type</label>
                        <select name="type" id="mediaType" class="p-input mt-1">
                            <option value="image">Image</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <div>
                        <label class="p-label">Grid Layout</label>
                        <select name="layout" class="p-input mt-1">
                            <option value="standard">Standard (Square)</option>
                            <option value="wide">Wide (2 Columns)</option>
                            <option value="tall">Tall (2 Rows)</option>
                        </select>
                    </div>
                    <div>
                        <label class="p-label">Category (Optional)</label>
                        <input type="text" name="category" placeholder="e.g. Rooms, Nature, Events" class="p-input mt-1">
                    </div>
                    <div class="md:col-span-2">
                        <label class="p-label">Title (Optional)</label>
                        <input type="text" name="title" placeholder="A short description" class="p-input mt-1">
                    </div>
                    <div class="md:col-span-2">
                        <label class="p-label">Select File</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-orange-200 border-dashed rounded-xl hover:border-[#e06828] transition-colors cursor-pointer" onclick="document.getElementById('mediaInput').click()">
                            <div class="space-y-1 text-center">
                                <i data-lucide="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                                <div class="flex text-sm text-gray-600">
                                    <span class="relative cursor-pointer bg-white rounded-md font-medium text-[#e06828] hover:text-[#fa873e] focus-within:outline-none">
                                        Upload a file
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, MP4 up to 20MB</p>
                            </div>
                            <input id="mediaInput" name="media" type="file" class="hidden" accept="image/*,video/*" onchange="previewMedia(this)">
                        </div>
                    </div>
                </div>

                <!-- Preview Area -->
                <div id="previewArea" class="hidden mt-4">
                    <p class="p-label mb-2">Preview</p>
                    <div class="relative w-full max-w-md h-64 bg-gray-100 rounded-xl overflow-hidden border border-orange-100">
                        <img id="imagePreview" class="hidden w-full h-full object-cover">
                        <video id="videoPreview" class="hidden w-full h-full object-cover" controls></video>
                        <button type="button" onclick="resetPreview()" class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="submitBtn" class="p-btn flex items-center">
                        <i data-lucide="send" class="w-4 h-4 mr-2"></i> Upload to Gallery
                    </button>
                </div>
            </form>
        </div>

        <!-- Gallery Grid -->
        <div class="p-card p-6 sm:p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="p-serif text-xl font-bold flex items-center" style="color:#3e2010;">
                    <i data-lucide="layout-grid" class="w-5 h-5 mr-2 text-[#e06828]"></i> Current Gallery
                </h3>
                <p class="text-xs text-gray-500 italic">Drag items to reorder them</p>
            </div>

            <div id="galleryContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($galleries as $item)
                <div class="gallery-item group relative aspect-square bg-gray-100 rounded-xl overflow-hidden border border-orange-50 cursor-move" data-id="{{ $item->id }}">
                    @if($item->type === 'image')
                        <img src="{{ $item->url }}" class="w-full h-full object-cover">
                    @else
                        <video src="{{ $item->url }}" class="w-full h-full object-cover"></video>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <i data-lucide="play-circle" class="w-10 h-10 text-white opacity-80"></i>
                        </div>
                    @endif

                    <!-- Overlay Actions -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col justify-between p-3">
                        <div class="flex justify-end gap-2">
                            <button onclick="editItem({{ $item->id }}, '{{ $item->title }}', '{{ $item->category }}', '{{ $item->layout }}')" class="p-1.5 bg-white/20 hover:bg-white/40 text-white rounded-lg backdrop-blur-md transition-colors" title="Edit Info">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </button>
                            <button onclick="deleteItem({{ $item->id }})" class="p-1.5 bg-red-500/80 hover:bg-red-600 text-white rounded-lg backdrop-blur-md transition-colors" title="Delete">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <div class="text-white">
                            <p class="text-xs font-bold truncate">{{ $item->title ?? 'Untitled' }}</p>
                            <p class="text-[10px] opacity-80 uppercase tracking-wider">{{ $item->category ?? 'General' }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($galleries->isEmpty())
            <div id="emptyState" class="text-center py-20">
                <i data-lucide="image-off" class="w-16 h-16 text-orange-100 mx-auto mb-4"></i>
                <p class="p-serif italic text-lg text-gray-500">Your gallery is currently empty.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
        <div class="p-card w-full max-w-md p-6">
            <h3 class="p-serif text-xl font-bold mb-4 flex items-center" style="color:#3e2010;">
                <i data-lucide="edit" class="w-5 h-5 mr-2 text-[#e06828]"></i> Edit Item Info
            </h3>
            <form id="editForm">
                @csrf
                @method('PATCH')
                <input type="hidden" id="editId">
                <div class="space-y-4">
                    <div>
                        <label class="p-label">Title</label>
                        <input type="text" id="editTitle" name="title" class="p-input mt-1">
                    </div>
                    <div>
                        <label class="p-label">Category</label>
                        <input type="text" id="editCategory" name="category" class="p-input mt-1">
                    </div>
                    <div>
                        <label class="p-label">Grid Layout</label>
                        <select id="editLayout" name="layout" class="p-input mt-1">
                            <option value="standard">Standard (Square)</option>
                            <option value="wide">Wide (2 Columns)</option>
                            <option value="tall">Tall (2 Rows)</option>
                        </select>
                    </div>
                    <div class="flex gap-2 pt-2">
                        <button type="button" onclick="closeEditModal()" class="flex-1 px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition-colors font-bold uppercase text-xs tracking-wider">Cancel</button>
                        <button type="submit" class="flex-1 p-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Media Preview Logic
        function previewMedia(input) {
            const previewArea = document.getElementById('previewArea');
            const imgPreview = document.getElementById('imagePreview');
            const vidPreview = document.getElementById('videoPreview');
            const file = input.files[0];
            
            if (file) {
                previewArea.classList.remove('hidden');
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        imgPreview.src = e.target.result;
                        imgPreview.classList.remove('hidden');
                        vidPreview.classList.add('hidden');
                    } else if (file.type.startsWith('video/')) {
                        vidPreview.src = e.target.result;
                        vidPreview.classList.remove('hidden');
                        imgPreview.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        function resetPreview() {
            document.getElementById('mediaInput').value = '';
            document.getElementById('previewArea').classList.add('hidden');
            document.getElementById('imagePreview').src = '';
            document.getElementById('videoPreview').src = '';
        }

        // Upload Form Logic
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const originalContent = btn.innerHTML;
            
            btn.disabled = true;
            btn.innerHTML = '<i class="w-4 h-4 mr-2 animate-spin border-2 border-white border-t-transparent rounded-full"></i> Uploading...';

            const formData = new FormData(this);
            try {
                const res = await fetch('{{ route("admin.gallery.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (err) {
                console.error(err);
                alert('An error occurred while uploading.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
        });

        // Reordering Logic
        const container = document.getElementById('galleryContainer');
        if (container) {
            new Sortable(container, {
                animation: 150,
                ghostClass: 'opacity-50',
                onEnd: async function() {
                    const order = Array.from(container.children).map(item => item.dataset.id);
                    await fetch('{{ route("admin.gallery.reorder") }}', {
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

        // Delete Logic
        async function deleteItem(id) {
            if (!confirm('Are you sure you want to delete this item?')) return;
            
            try {
                const res = await fetch(`/admin/gallery/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    document.querySelector(`[data-id="${id}"]`).remove();
                    if (container.children.length === 0) {
                        window.location.reload();
                    }
                }
            } catch (err) {
                console.error(err);
            }
        }

        // Edit Modal Logic
        function editItem(id, title, category, layout) {
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title === 'null' ? '' : title;
            document.getElementById('editCategory').value = category === 'null' ? '' : category;
            document.getElementById('editLayout').value = layout;
            
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('editForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const formData = new FormData(this);
            
            try {
                const res = await fetch(`/admin/gallery/${id}`, {
                    method: 'POST', // Spoofed as PATCH by @method('PATCH')
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                // Since this is a standard form submit via fetch, but we use back() in controller,
                // it might be easier to just reload.
                window.location.reload();
            } catch (err) {
                console.error(err);
            }
        });
    </script>
    @endpush
</x-admin-layout>
