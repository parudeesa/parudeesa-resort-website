<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Coupon Management
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
            <!-- Add Coupon Form -->
            <div class="lg:col-span-1">
                <div class="p-card p-6 sm:p-8 h-full sticky top-8">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="ticket" class="w-5 h-5 mr-2 text-[#e06828]"></i> Add New Coupon
                    </h3>
                    <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="p-label">Coupon Code</label>
                            <input name="code" type="text" class="p-input mt-1" placeholder="SAVE10" required minlength="3" maxlength="50" pattern="[a-zA-Z0-9_-]+" title="Code can only contain letters, numbers, underscores and dashes." />
                        </div>
                        <div>
                            <label class="p-label">Discount Type</label>
                            <select name="type" class="p-input mt-1" required>
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount (₹)</option>
                            </select>
                        </div>
                        <div>
                            <label class="p-label">Discount Value</label>
                            <input name="value" type="number" step="0.01" min="0" max="100000" class="p-input mt-1" placeholder="10" required />
                        </div>
                        <div class="pt-4 mt-2">
                            <button type="submit" class="p-btn w-full flex justify-center items-center">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Create Coupon
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Coupon List Table -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <div class="p-card p-6 sm:p-8 flex-1">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                        <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                            <i data-lucide="tag" class="w-5 h-5 mr-2 text-[#e06828]"></i> Active Coupons
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                            <thead style="background:rgba(250,135,62,.05)">
                                <tr>
                                    <th class="px-6 py-4 text-left p-label rounded-tl-lg">Code</th>
                                    <th class="px-6 py-4 text-left p-label">Discount</th>
                                    <th class="px-6 py-4 text-left p-label">Status</th>
                                    <th class="px-6 py-4 text-left p-label">Created</th>
                                    <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                                @foreach($coupons as $coupon)
                                <tr class="hover:bg-orange-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="bg-orange-100 text-[#e06828] font-black px-3 py-1 rounded border border-orange-200">
                                                {{ $coupon->code }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold p-text">
                                            {{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₹' . number_format($coupon->value, 2) }}
                                            <span class="text-xs text-gray-400 font-normal ml-1">OFF</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $coupon->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $coupon->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.coupons.toggle_status', $coupon->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="{{ $coupon->is_active ? 'bg-orange-100 text-[#e06828]' : 'bg-green-100 text-green-600' }} p-2 rounded-lg transition-colors" title="{{ $coupon->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i data-lucide="{{ $coupon->is_active ? 'power-off' : 'power' }}" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this coupon?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 text-red-600 p-2 rounded-lg transition-colors" title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @if($coupons->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic font-serif">
                                        No coupons created yet.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
