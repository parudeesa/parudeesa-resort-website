<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Pricing & Services Management') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
                <div>
                    <h1 class="text-4xl font-extrabold p-serif text-[#3e2010] tracking-tight">Food Packages</h1>
                    <p class="text-gray-500 text-sm mt-2 flex items-center gap-2">
                        <i data-lucide="banknote" class="w-4 h-4 text-orange-300"></i>
                        Manage pricing and details for property food packages.
                    </p>
                </div>
                <div class="flex gap-4">
                    <button onclick="openFoodModal()" class="p-btn flex items-center gap-3 px-8 py-4 shadow-xl hover:shadow-orange-200/50 group transition-all duration-500 rounded-2xl">
                        <div class="bg-white/20 p-1.5 rounded-lg group-hover:rotate-90 transition-transform duration-500">
                            <i data-lucide="plus" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-sm font-bold uppercase tracking-widest">Add Package</span>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50/50 border border-green-100 text-green-800 p-5 rounded-2xl shadow-sm flex items-center justify-between animate-fade-in backdrop-blur-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i data-lucide="check" class="w-5 h-5"></i>
                        </div>
                        <span class="font-bold text-sm tracking-tight">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-green-100 text-green-400 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            <!-- Food Packages Table -->
            <div class="animate-fade-in">
                <div class="p-card overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-orange-50/50 border-b border-orange-100/50">
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Package Name</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Price (₹)</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Description</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828]">Status</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-[#e06828] text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-orange-50">
                            @foreach($foodPackages as $package)
                            <tr class="hover:bg-orange-50/30 transition-colors group">
                                <td class="px-8 py-6 font-bold text-[#3e2010]">{{ $package->name }}</td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-bold text-[#e06828] bg-orange-50 px-2 py-1 rounded">₹{{ number_format($package->price) }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-gray-500 max-w-xs truncate">{{ $package->description }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $package->status ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                                        {{ $package->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick="editFood(JSON.parse(this.dataset.pkg))" data-pkg="{{ json_encode($package) }}" class="p-2 bg-white border border-orange-100 text-orange-400 rounded-lg hover:text-[#e06828] hover:shadow-md transition-all">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <form action="{{ route('admin.pricing.food.delete', $package->id) }}" method="POST" onsubmit="return confirm('Delete this package?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 border border-red-100 text-red-400 rounded-lg hover:text-red-600 hover:shadow-md transition-all">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Food Modal -->
    <div id="foodModal" class="fixed inset-0 bg-[#3e2010]/40 backdrop-blur-md hidden z-50 animate-fade-in flex items-center justify-center p-4">
        <div class="bg-[#fffaf7] rounded-[2rem] max-w-lg w-full shadow-2xl animate-slide-up overflow-hidden">
            <div class="px-8 py-6 border-b border-orange-100/50 flex justify-between items-center">
                <h3 id="foodModalTitle" class="text-2xl font-bold p-serif text-[#3e2010]">Add Food Package</h3>
                <button onclick="closeModals()" class="text-gray-400 hover:text-orange-500 transition-colors">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            <form id="foodForm" method="POST" class="p-8 space-y-6">
                @csrf
                <div id="foodMethod"></div>
                <div>
                    <label class="p-label mb-2 block">Package Name</label>
                    <input type="text" name="name" id="f_name" class="p-input" required>
                </div>
                <div>
                    <label class="p-label mb-2 block">Price (₹)</label>
                    <input type="number" name="price" id="f_price" class="p-input" required>
                </div>
                <div>
                    <label class="p-label mb-2 block">Description</label>
                    <textarea name="description" id="f_description" class="p-input" rows="3"></textarea>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="status" value="1" id="f_status" checked class="w-4 h-4 text-[#e06828] focus:ring-[#e06828] border-orange-200 rounded">
                    <label for="f_status" class="text-sm font-bold text-gray-600 uppercase tracking-widest">Active</label>
                </div>
                <button type="submit" class="p-btn w-full py-4 mt-4">Save Package</button>
            </form>
        </div>
    </div>

    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
        .animate-slide-up { animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
        function openFoodModal() {
            document.getElementById('foodModalTitle').innerText = 'Add Food Package';
            document.getElementById('foodForm').action = "{{ route('admin.pricing.food.store') }}";
            document.getElementById('foodMethod').innerHTML = '';
            document.getElementById('foodForm').reset();
            document.getElementById('foodModal').classList.remove('hidden');
        }

        function editFood(pkg) {
            document.getElementById('foodModalTitle').innerText = 'Edit Food Package';
            document.getElementById('foodForm').action = `/admin/pricing/food/${pkg.id}`;
            document.getElementById('foodMethod').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
            document.getElementById('f_name').value = pkg.name;
            document.getElementById('f_price').value = pkg.price;
            document.getElementById('f_description').value = pkg.description || '';
            document.getElementById('f_status').checked = !!pkg.status;
            document.getElementById('foodModal').classList.remove('hidden');
        }

        function closeModals() {
            document.getElementById('foodModal').classList.add('hidden');
        }

        window.onclick = function(e) {
            if (e.target.classList.contains('fixed')) closeModals();
        }
    </script>
</x-admin-layout>
