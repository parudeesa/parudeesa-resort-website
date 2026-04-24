<x-app-layout>
    <x-slot name="header">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet"/>
        <style>
            .parudeesa-bg { background-color: #fff3ec !important; font-family: 'Josefin Sans', sans-serif !important; }
            .p-serif { font-family: 'Cormorant Garamond', serif !important; }
            .p-card { background: #fff8f3; border: 1px solid rgba(250,135,62,.15); box-shadow: 0 6px 32px rgba(250,135,62,.15); border-radius: 16px; }
            .p-btn { background: linear-gradient(135deg, #fa873e, #e06828); color: white; border: none; padding: 0.6rem 1.5rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; border-radius: 8px; box-shadow: 0 4px 18px rgba(250,135,62,.35); transition: transform 0.3s ease; }
            .p-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(250,135,62,.45); color: white; }
            .p-input { border: 1.5px solid rgba(250,135,62,.25); border-radius: 8px; padding: 0.5rem 1rem; width: 100%; box-shadow: none !important; }
            .p-input:focus { border-color: #e06828; outline: none; }
            .p-label { color: #e06828; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase; }
            .p-text { color: #3e2010; }
        </style>

        <h2 class="p-serif font-semibold text-3xl" style="color:#e06828;">
            ✦ Amenities Management ✦
        </h2>
    </x-slot>

    <div class="py-12 parudeesa-bg min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Add Amenity Card -->
            <div class="p-card overflow-hidden p-8">
                <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Add New Amenity</h3>
                <form action="{{ route('amenities.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="p-label">Amenity Name</label>
                            <input id="name" name="name" type="text" class="p-input mt-1" placeholder="e.g., Swimming Pool, WiFi, etc." required />
                        </div>
                        <div>
                            <label class="p-label">Description (Optional)</label>
                            <input id="description" name="description" type="text" class="p-input mt-1" placeholder="Brief description of the amenity" />
                        </div>
                    </div>
                    <button type="submit" class="p-btn">
                        <i class="bi bi-plus-circle mr-2"></i>Add Amenity
                    </button>
                </form>
            </div>

            <!-- Amenities List Card -->
            <div class="p-card overflow-hidden p-8">
                <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Existing Amenities</h3>

                @if($amenities->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-4 font-semibold p-text">Name</th>
                                    <th class="text-left py-4 px-4 font-semibold p-text">Description</th>
                                    <th class="text-left py-4 px-4 font-semibold p-text">Created</th>
                                    <th class="text-right py-4 px-4 font-semibold p-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($amenities as $amenity)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="font-medium p-text">{{ $amenity->name }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-gray-600">{{ $amenity->description ?: 'No description' }}</div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="text-gray-600">{{ $amenity->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="py-4 px-4 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <!-- Edit Button -->
                                                <button onclick="editAmenity({{ $amenity->id }}, '{{ addslashes($amenity->name) }}', '{{ addslashes($amenity->description ?? '') }}')"
                                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition-all duration-300">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <!-- Delete Button -->
                                                <form action="{{ route('amenities.destroy', $amenity) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this amenity?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg transition-all duration-300">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="bi bi-list-ul text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-semibold p-text mb-2">No amenities yet</h3>
                        <p class="text-gray-600">Add your first amenity using the form above.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl p-serif font-bold p-text">Edit Amenity</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="bi bi-x-lg text-2xl"></i>
                    </button>
                </div>

                <form id="editForm" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-sm font-medium p-text mb-2">Amenity Name</label>
                        <input type="text" id="editName" name="name" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-medium p-text mb-2">Description (Optional)</label>
                        <input type="text" id="editDescription" name="description"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all">
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            Update Amenity
                        </button>
                        <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-all duration-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function editAmenity(id, name, description) {
        document.getElementById('editForm').action = `/amenities/${id}`;
        document.getElementById('editName').value = name;
        document.getElementById('editDescription').value = description;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
    </script>
</x-app-layout>