<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('Event Inquiries') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold p-serif text-[#3e2010]">Bespoke Event Inquiries</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage and respond to luxury event visions from your guests.</p>
                </div>
            </div>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r-lg shadow-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="p-card overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-orange-100">
                        <thead class="bg-orange-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left p-label">Guest</th>
                                <th class="px-6 py-4 text-left p-label">Event Type</th>
                                <th class="px-6 py-4 text-left p-label">Date</th>
                                <th class="px-6 py-4 text-left p-label">Guests</th>
                                <th class="px-6 py-4 text-left p-label">Stay</th>
                                <th class="px-6 py-4 text-left p-label">Status</th>
                                <th class="px-6 py-4 text-right p-label">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-orange-50">
                            @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-[#3e2010]">{{ $inquiry->name }}</span>
                                        <span class="text-xs text-gray-500">{{ $inquiry->phone }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $inquiry->event_type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="flex flex-col">
                                        <span class="font-bold">{{ \Carbon\Carbon::parse($inquiry->event_date)->format('M d, Y') }}</span>
                                        <span class="text-xs text-[#e06828]">{{ $inquiry->event_time ?: 'No time' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $inquiry->guests }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($inquiry->need_stay === 'Yes')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i data-lucide="moon" class="w-3 h-3 mr-1"></i> Yes ({{ $inquiry->stay_guests ?? '?' }})
                                    </span>
                                    @else
                                    <span class="text-xs text-gray-400">No</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wider
                                        @if($inquiry->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($inquiry->status == 'responded') bg-blue-100 text-blue-800
                                        @elseif($inquiry->status == 'confirmed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $inquiry->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.events.show', $inquiry->id) }}" class="inline-flex items-center p-2 bg-orange-50 text-[#e06828] rounded-lg hover:bg-[#e06828] hover:text-white transition-all shadow-sm" title="View Details">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $inquiry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Archive this inquiry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach

                            @if($inquiries->isEmpty())
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                    No event inquiries found.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($inquiries->hasPages())
                <div class="px-6 py-4 bg-orange-50/30 border-t border-orange-100">
                    {{ $inquiries->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
