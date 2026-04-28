<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Dashboard Overview
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

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Properties Card -->
            <div class="p-card p-6 flex items-center justify-between transition-transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div>
                    <p class="p-label mb-1 text-gray-500">Total Properties</p>
                    <h3 class="p-serif text-3xl font-bold p-text">{{ \App\Models\Property::count() }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828]">
                    <i data-lucide="home" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Amenities Card -->
            <div class="p-card p-6 flex items-center justify-between transition-transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div>
                    <p class="p-label mb-1 text-gray-500">Total Amenities</p>
                    <h3 class="p-serif text-3xl font-bold p-text">{{ \App\Models\Amenity::count() }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828]">
                    <i data-lucide="sparkles" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Bookings Card -->
            <div class="p-card p-6 flex items-center justify-between transition-transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div>
                    <p class="p-label mb-1 text-gray-500">Total Bookings</p>
                    <h3 class="p-serif text-3xl font-bold p-text">{{ \App\Models\Booking::count() }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828]">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="p-card p-6 flex items-center justify-between transition-transform hover:-translate-y-1 hover:shadow-xl duration-300">
                <div>
                    <p class="p-label mb-1 text-gray-500">Total Revenue</p>
                    <h3 class="p-serif text-3xl font-bold p-text">₹{{ number_format(\App\Models\Booking::where('status', 'confirmed')->sum('amount') ?? 0) }}</h3>
                </div>
                <div class="h-12 w-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                    <i data-lucide="indian-rupee" class="w-6 h-6"></i>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Recent Bookings Card -->
            <div class="p-card p-6 sm:p-8 flex flex-col h-full">
                <div class="flex justify-between items-center mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                    <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                        <i data-lucide="calendar-clock" class="w-5 h-5 mr-2 text-[#e06828]"></i> Recent Bookings
                    </h3>
                    <a href="{{ route('bookings.index') }}" class="text-sm font-semibold text-[#e06828] hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                        <thead style="background:rgba(250,135,62,.05)">
                            <tr>
                                <th class="px-6 py-4 text-left p-label rounded-tl-lg">Customer</th>
                                <th class="px-6 py-4 text-left p-label">Property</th>
                                <th class="px-6 py-4 text-left p-label">Check-in</th>
                                <th class="px-6 py-4 text-left p-label rounded-tr-lg">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                            @foreach(App\Models\Booking::with('property')->latest()->take(5)->get() as $booking)
                            <tr class="hover:bg-orange-50/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap text-md font-bold p-text">{{ $booking->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $booking->property->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide
                                        @if($booking->status == 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach

                            @if(App\Models\Booking::count() == 0)
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center p-text italic">No bookings yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col gap-8">
                <!-- Booking Calendar Snapshot / Upcoming Check-ins -->
                <div class="p-card p-6 sm:p-8 flex-1">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="calendar-range" class="w-5 h-5 mr-2 text-[#e06828]"></i> Upcoming Check-ins
                    </h3>
                    <div class="space-y-4">
                        @foreach(App\Models\Booking::with('property')->where('check_in', '>=', now()->toDateString())->orderBy('check_in', 'asc')->take(4)->get() as $upcoming)
                        <div class="flex items-center p-4 bg-white/60 rounded-xl border border-orange-50 hover:border-orange-200 transition-colors">
                            <div class="h-12 w-12 rounded-lg bg-orange-100 flex flex-col items-center justify-center text-[#e06828] mr-4 flex-shrink-0">
                                <span class="text-xs font-bold uppercase">{{ \Carbon\Carbon::parse($upcoming->check_in)->format('M') }}</span>
                                <span class="text-lg font-bold leading-none">{{ \Carbon\Carbon::parse($upcoming->check_in)->format('d') }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $upcoming->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $upcoming->property->name ?? 'N/A' }} • {{ $upcoming->guests }} Guests</p>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <span class="text-sm font-semibold text-gray-600">{{ \Carbon\Carbon::parse($upcoming->check_out)->diffInDays(\Carbon\Carbon::parse($upcoming->check_in)) }} Nights</span>
                            </div>
                        </div>
                        @endforeach

                        @if(App\Models\Booking::where('check_in', '>=', now()->toDateString())->count() == 0)
                        <div class="text-center py-8">
                            <i data-lucide="calendar-x" class="w-12 h-12 text-orange-200 mx-auto mb-3"></i>
                            <p class="font-serif italic text-lg text-gray-500">No upcoming check-ins.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Booking Calendar Link -->
                <div class="p-card p-6 sm:p-8 flex items-center justify-between">
                    <div>
                        <h3 class="p-serif text-xl font-bold flex items-center mb-2" style="color:#3e2010;">
                            <i data-lucide="calendar" class="w-5 h-5 mr-2 text-[#e06828]"></i> Google Calendar
                        </h3>
                        <p class="text-sm text-gray-500">View all bookings in Google Calendar. Syncs automatically.</p>
                    </div>
                    <a href="{{ route('admin.calendar') }}" class="p-btn whitespace-nowrap">
                        <i data-lucide="external-link" class="w-4 h-4 mr-2 inline"></i> Open Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>