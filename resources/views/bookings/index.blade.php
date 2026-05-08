<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">Bookings Overview</h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="p-card p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                <div>
                    <h3 class="p-serif text-2xl font-bold" style="color:#3e2010;">{{ auth()->user()->isSuperAdmin() ? 'All' : 'My' }} Bookings</h3>
                    <p class="text-sm text-gray-500">Review full details of reservations and manage statuses.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Search bookings..." class="p-input pl-10 text-sm py-2">
                    </div>
                    <div class="text-sm text-gray-600 whitespace-nowrap hidden sm:block">
                        Total: <span class="font-semibold text-[#e06828]">{{ isset($bookings) ? $bookings->total() : ($upcomingBookings->count() + $pastBookings->count()) }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                    <thead style="background:rgba(250,135,62,.05)">
                        <tr>
                            <th class="px-6 py-4 text-left p-label rounded-tl-lg">Customer</th>
                            <th class="px-6 py-4 text-left p-label">Stay Details</th>
                            <th class="px-6 py-4 text-left p-label">Amount</th>
                            <th class="px-6 py-4 text-left p-label">Status</th>
                            <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                        @php
                            $segments = isset($upcomingBookings) 
                                ? [['label' => 'Upcoming & Current', 'items' => $upcomingBookings, 'icon' => 'calendar-days'], ['label' => 'Past Bookings', 'items' => $pastBookings, 'icon' => 'history']]
                                : [['label' => null, 'items' => $bookings, 'icon' => null]];
                        @endphp

                        @foreach($segments as $segment)
                            @if($segment['label'])
                                <tr class="bg-orange-50/40">
                                    <td colspan="5" class="px-6 py-2.5 font-bold text-[11px] uppercase tracking-widest text-orange-900 border-y border-orange-100">
                                        <div class="flex items-center">
                                            <i data-lucide="{{ $segment['icon'] }}" class="w-3.5 h-3.5 mr-2"></i>
                                            {{ $segment['label'] }}
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @forelse($segment['items'] as $booking)
                                <tr class="hover:bg-orange-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold p-text text-md">{{ $booking->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $booking->phone }}</div>
                                        <div class="text-[10px] text-gray-400">Booked: {{ $booking->created_at->format('M d, Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($booking->type === 'yacht')
                                            <div class="text-sm p-text font-semibold">{{ $booking->yacht->name ?? 'Luxury Yacht' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                                            </div>
                                            <div class="text-[10px] text-blue-600 font-bold uppercase">Independent Yacht Charter</div>
                                        @else
                                            <div class="text-sm p-text font-semibold">{{ $booking->property->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d') }} - {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                                            </div>
                                            <div class="text-[10px] text-orange-600 font-bold uppercase">{{ $booking->package_name ?? 'Base Package' }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold" style="color:#e06828">₹{{ number_format($booking->amount, 2) }}</div>
                                        <div class="text-[10px] text-gray-500">{{ $booking->payment_status ?? 'Payment Pending' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide
                                            @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $booking->status }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <button onclick="document.getElementById('details-{{ $booking->id }}').classList.toggle('hidden')" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="View Full Details">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </button>

                                            @if(!auth()->user()->isCustomer())
                                                @if($booking->status === 'pending')
                                                <form action="{{ route('bookings.update_status', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="bg-green-50 hover:bg-green-100 text-green-600 p-2 rounded-lg transition-colors" title="Confirm Booking">
                                                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                @if($booking->status !== 'cancelled')
                                                <form action="{{ route('bookings.update_status', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Cancel Booking">
                                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <!-- Detailed View -->
                                <tr id="details-{{ $booking->id }}" class="hidden bg-orange-50/20">
                                    <td colspan="5" class="px-6 py-6">
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                                            <div class="space-y-3">
                                                <h4 class="font-bold p-text uppercase text-[10px] tracking-widest border-b border-orange-100 pb-1">Customer Info</h4>
                                                <p><span class="text-gray-500 font-medium">Name:</span> <span class="p-text font-semibold">{{ $booking->name }}</span></p>
                                                <p><span class="text-gray-500 font-medium">Phone:</span> <span class="p-text font-semibold">{{ $booking->phone }}</span></p>
                                                <p><span class="text-gray-500 font-medium">Email:</span> <span class="p-text font-semibold">{{ $booking->email }}</span></p>
                                                <p><span class="text-gray-500 font-medium">Guests:</span> <span class="p-text font-semibold">{{ $booking->guests }} Persons</span></p>
                                            </div>
                                            <div class="space-y-3">
                                                <h4 class="font-bold p-text uppercase text-[10px] tracking-widest border-b border-orange-100 pb-1">Stay Details</h4>
                                                @if($booking->type === 'yacht')
                                                    <p><span class="text-gray-500 font-medium">Type:</span> <span class="p-text font-semibold text-blue-600">Yacht Booking</span></p>
                                                    <p><span class="text-gray-500 font-medium">Yacht:</span> <span class="p-text font-semibold">{{ $booking->yacht->name ?? 'Luxury Yacht' }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Date:</span> <span class="p-text font-semibold">{{ \Carbon\Carbon::parse($booking->check_in)->format('l, M d, Y') }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Duration:</span> <span class="p-text font-semibold">{{ $booking->yacht->duration ?? '5 Hours' }}</span></p>
                                                @else
                                                    <p><span class="text-gray-500 font-medium">Property:</span> <span class="p-text font-semibold">{{ $booking->property->name ?? 'N/A' }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Stay Type:</span> <span class="p-text font-semibold">{{ $booking->event_type ?? 'Standard Stay' }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Package:</span> <span class="p-text font-semibold">{{ $booking->package_name ?? 'Base Plan' }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Check-In:</span> <span class="p-text font-semibold">{{ \Carbon\Carbon::parse($booking->check_in)->format('l, M d, Y') }}</span></p>
                                                    <p><span class="text-gray-500 font-medium">Check-Out:</span> <span class="p-text font-semibold">{{ \Carbon\Carbon::parse($booking->check_out)->format('l, M d, Y') }}</span></p>
                                                @endif
                                            </div>
                                            <div class="space-y-3">
                                                <h4 class="font-bold p-text uppercase text-[10px] tracking-widest border-b border-orange-100 pb-1">Pricing & Amenities</h4>
                                                @if($booking->amenities && count($booking->amenities) > 0)
                                                    <div class="space-y-1">
                                                        <p class="text-gray-500 font-medium">Selected Amenities:</p>
                                                        @foreach($booking->amenities as $id => $data)
                                                            @if(isset($data['selected']) && $data['selected'])
                                                                <div class="flex justify-between items-center bg-white/60 p-2 rounded border border-orange-50 text-[11px]">
                                                                    <span>{{ $data['name'] ?? 'Amenity' }} 
                                                                        @if(isset($data['participants']) && $data['participants'] > 1)
                                                                            (x{{ $data['participants'] }})
                                                                        @endif
                                                                    </span>
                                                                    <span class="font-semibold text-orange-600">₹{{ number_format(($data['price'] ?? 0) * ($data['participants'] ?? 1), 2) }}</span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-gray-400 italic text-xs">No extra amenities selected.</p>
                                                @endif

                                                @if($booking->notes)
                                                    <div class="mt-3 p-2 bg-blue-50 border border-blue-100 rounded text-[11px]">
                                                        <span class="font-bold text-blue-700 block mb-1">SPECIAL REQUESTS:</span>
                                                        <span class="text-blue-900">{{ $booking->notes }}</span>
                                                    </div>
                                                @endif
                                                <div class="pt-2 border-t border-orange-100 flex justify-between items-center">
                                                    <span class="font-bold p-text">Total Price:</span>
                                                    <span class="text-lg font-bold text-[#e06828]">₹{{ number_format($booking->amount, 2) }}</span>
                                                </div>
                                                <p><span class="text-gray-500 font-medium">Payment Status:</span> <span class="uppercase font-bold text-[10px] {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-orange-600' }}">{{ $booking->payment_status ?? 'Pending' }}</span></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center p-text italic">
                                        <div class="flex flex-col items-center justify-center">
                                            <i data-lucide="calendar-x" class="w-12 h-12 text-orange-200 mb-3"></i>
                                            No {{ $segment['label'] ? strtolower($segment['label']) : 'bookings' }} available yet.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                @if(isset($bookings))
                    {{ $bookings->links() }}
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
