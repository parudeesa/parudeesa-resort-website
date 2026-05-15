<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Yacht Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold p-serif text-[#e06828]">Manage Yachts</h1>
                <button onclick="document.getElementById('addYachtModal').classList.remove('hidden')" class="p-btn flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    Add New Yacht
                </button>
            </div>

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($yachts as $yacht)
                    <div class="p-card overflow-hidden group">
                        <div class="h-48 overflow-hidden relative">
                            @if($yacht->image)
                                <img src="{{ asset($yacht->image) }}" alt="{{ $yacht->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-orange-50 flex items-center justify-center text-orange-200">
                                    <i data-lucide="ship" class="w-12 h-12"></i>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold p-serif text-[#3e2010]">{{ $yacht->name }}</h3>
                                <span class="px-2 py-1 rounded text-xs font-bold {{ $yacht->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $yacht->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $yacht->description }}</p>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-orange-50 p-2 rounded">
                                    <div class="text-[10px] uppercase text-orange-400 font-bold">Price</div>
                                    <div class="font-bold text-[#e06828]">₹{{ number_format($yacht->price) }}</div>
                                </div>
                                <div class="bg-orange-50 p-2 rounded">
                                    <div class="text-[10px] uppercase text-orange-400 font-bold">Duration</div>
                                    <div class="font-bold text-[#e06828]">{{ $yacht->duration }}</div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button onclick="editYacht({{ json_encode($yacht) }})" class="flex-1 py-2 bg-white border border-orange-200 text-orange-600 rounded-lg hover:bg-orange-50 transition-colors font-bold text-sm">Edit</button>
                                <form action="{{ route('admin.yachts.delete', $yacht->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                <h2 class="text-2xl font-bold p-serif text-[#e06828] mb-6">Yacht Bookings</h2>
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-orange-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-orange-50 border-b border-orange-100">
                                <tr>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Guest</th>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Yacht</th>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Date</th>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Status</th>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Amount</th>
                                    <th class="px-6 py-4 text-[10px] uppercase tracking-wider font-bold text-orange-400">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-orange-50">
                                @forelse($bookings as $booking)
                                    <tr class="hover:bg-orange-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#3e2010]">{{ $booking->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->phone }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                                            {{ $booking->yacht->name ?? 'Luxury Yacht' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-bold text-[#e06828]">
                                            ₹{{ number_format($booking->amount) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex gap-2">
                                                @if($booking->status === 'pending')
                                                    <form action="{{ route('bookings.update_status', $booking->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="confirmed">
                                                        <button type="submit" class="text-green-600 hover:text-green-800 text-xs font-bold uppercase">Confirm</button>
                                                    </form>
                                                @endif
                                                <button onclick="alert('Special Requests: {{ addslashes($booking->notes ?: 'None') }}')" class="text-blue-600 hover:text-blue-800 text-xs font-bold uppercase">Details</button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">No yacht bookings found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Yacht Modal -->
    <div id="addYachtModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold p-serif text-[#e06828]">Add New Yacht</h2>
                <button onclick="document.getElementById('addYachtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form action="{{ route('admin.yachts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="p-label">Yacht Name</label>
                        <input type="text" name="name" class="p-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="p-label">Description</label>
                        <textarea name="description" class="p-input" rows="3" required></textarea>
                    </div>
                    <div>
                        <label class="p-label">Price (₹)</label>
                        <input type="number" name="price" class="p-input" required>
                    </div>
                    <div>
                        <label class="p-label">Duration</label>
                        <input type="text" name="duration" class="p-input" placeholder="e.g. 5 Hours" required>
                    </div>
                    <div>
                        <label class="p-label">Capacity (Persons)</label>
                        <input type="number" name="capacity" class="p-input" required>
                    </div>
                    <div>
                        <label class="p-label">Yacht Image</label>
                        <input type="file" name="image" class="p-input" accept="image/*" required onchange="previewImage(this, 'add_preview')">
                        <div id="add_preview" class="mt-2 h-32 rounded-xl border border-orange-100 overflow-hidden hidden"></div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('addYachtModal').classList.add('hidden')" class="px-6 py-2 text-gray-600 font-bold uppercase tracking-wider text-xs">Cancel</button>
                    <button type="submit" class="p-btn">Save Yacht</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Yacht Modal -->
    <div id="editYachtModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold p-serif text-[#e06828]">Edit Yacht</h2>
                <button onclick="document.getElementById('editYachtModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="editYachtForm" method="POST" enctype="multipart/form-data">
                @csrf @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="p-label">Yacht Name</label>
                        <input type="text" name="name" id="edit_name" class="p-input" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="p-label">Description</label>
                        <textarea name="description" id="edit_description" class="p-input" rows="3" required></textarea>
                    </div>
                    <div>
                        <label class="p-label">Price (₹)</label>
                        <input type="number" name="price" id="edit_price" class="p-input" required>
                    </div>
                    <div>
                        <label class="p-label">Duration</label>
                        <input type="text" name="duration" id="edit_duration" class="p-input" required>
                    </div>
                    <div>
                        <label class="p-label">Capacity (Persons)</label>
                        <input type="number" name="capacity" id="edit_capacity" class="p-input" required>
                    </div>
                    <div>
                        <label class="p-label">Status</label>
                        <select name="status" id="edit_status" class="p-input">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="p-label">Yacht Image (Leave empty to keep current)</label>
                        <input type="file" name="image" class="p-input" accept="image/*" onchange="previewImage(this, 'edit_preview')">
                        <div id="edit_preview" class="mt-2 h-40 rounded-xl border border-orange-100 overflow-hidden"></div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end gap-4">
                    <button type="button" onclick="document.getElementById('editYachtModal').classList.add('hidden')" class="px-6 py-2 text-gray-600 font-bold uppercase tracking-wider text-xs">Cancel</button>
                    <button type="submit" class="p-btn">Update Yacht</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editYacht(yacht) {
            document.getElementById('editYachtForm').action = `/admin/yachts/${yacht.id}`;
            document.getElementById('edit_name').value = yacht.name;
            document.getElementById('edit_description').value = yacht.description;
            document.getElementById('edit_price').value = yacht.price;
            document.getElementById('edit_duration').value = yacht.duration;
            document.getElementById('edit_capacity').value = yacht.capacity;
            document.getElementById('edit_status').value = yacht.status ? 1 : 0;
            
            const preview = document.getElementById('edit_preview');
            if (yacht.image) {
                preview.innerHTML = `<img src="{{ asset('') }}${yacht.image}" class="w-full h-full object-cover">`;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
            
            document.getElementById('editYachtModal').classList.remove('hidden');
            lucide.createIcons();
        }

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
    </script>
</x-admin-layout>
