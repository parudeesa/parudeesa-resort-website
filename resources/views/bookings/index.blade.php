<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">Bookings Overview</h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <div class="p-card p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                <div>
                    <h3 class="p-serif text-2xl font-bold" style="color:#3e2010;">All Bookings</h3>
                    <p class="text-sm text-gray-500">Review the latest booking requests and statuses.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Search bookings..." class="p-input pl-10 text-sm py-2">
                    </div>
                    <div class="text-sm text-gray-600 whitespace-nowrap hidden sm:block">
                        Total bookings: <span class="font-semibold text-[#e06828]">{{ $bookings->total() }}</span>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                    <thead style="background:rgba(250,135,62,.05)">
                        <tr>
                            <th class="px-6 py-4 text-left p-label rounded-tl-lg">Customer</th>
                            <th class="px-6 py-4 text-left p-label">Property</th>
                            <th class="px-6 py-4 text-left p-label">Dates</th>
                            <th class="px-6 py-4 text-left p-label">Amount</th>
                            <th class="px-6 py-4 text-left p-label">Status</th>
                            <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                        @forelse($bookings as $booking)
                        <tr class="hover:bg-orange-50/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold p-text text-md">{{ $booking->name }}</div>
                                <div class="text-xs text-gray-500">{{ $booking->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $booking->property->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div><span class="font-semibold p-text">In:</span> {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</div>
                                <div><span class="font-semibold p-text">Out:</span> {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" style="color:#e06828">₹{{ number_format($booking->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide
                                    @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $booking->status }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex justify-end gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="View Details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </button>
                                    <form action="#" method="POST" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                        @csrf
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Cancel Booking">
                                            <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center p-text italic flex-col items-center justify-center">
                                <i data-lucide="calendar-x" class="w-12 h-12 text-orange-200 mx-auto mb-3"></i>
                                No bookings available yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
