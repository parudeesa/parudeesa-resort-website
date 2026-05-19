<x-admin-layout>
    <x-slot name="header">
        Revenue Dashboard
    </x-slot>

    <!-- Top Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="p-card p-6 flex flex-col justify-between hover:shadow-[0_8px_40px_rgba(250,135,62,0.2)] transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-[#fa873e]/20 to-[#e06828]/20 flex items-center justify-center">
                    <i data-lucide="indian-rupee" class="w-6 h-6 text-[#e06828]"></i>
                </div>
                <span class="text-xs font-bold px-2 py-1 bg-[#10b981]/10 text-[#10b981] rounded-full uppercase tracking-wider">All Time</span>
            </div>
            <div>
                <h3 class="p-label mb-1">Total Revenue</h3>
                <div class="text-3xl font-bold p-text flex items-baseline gap-1">
                    <span class="text-lg">₹</span>{{ number_format($totalRevenue, 2) }}
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="p-card p-6 flex flex-col justify-between hover:shadow-[0_8px_40px_rgba(250,135,62,0.2)] transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-[#fa873e]/20 to-[#e06828]/20 flex items-center justify-center">
                    <i data-lucide="calendar" class="w-6 h-6 text-[#e06828]"></i>
                </div>
                <span class="text-xs font-bold px-2 py-1 bg-[#10b981]/10 text-[#10b981] rounded-full uppercase tracking-wider">This Month</span>
            </div>
            <div>
                <h3 class="p-label mb-1">Monthly Revenue</h3>
                <div class="text-3xl font-bold p-text flex items-baseline gap-1">
                    <span class="text-lg">₹</span>{{ number_format($monthlyRevenue, 2) }}
                </div>
            </div>
        </div>

        <!-- Weekly Revenue -->
        <div class="p-card p-6 flex flex-col justify-between hover:shadow-[0_8px_40px_rgba(250,135,62,0.2)] transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-[#fa873e]/20 to-[#e06828]/20 flex items-center justify-center">
                    <i data-lucide="calendar-days" class="w-6 h-6 text-[#e06828]"></i>
                </div>
                <span class="text-xs font-bold px-2 py-1 bg-[#10b981]/10 text-[#10b981] rounded-full uppercase tracking-wider">This Week</span>
            </div>
            <div>
                <h3 class="p-label mb-1">Weekly Revenue</h3>
                <div class="text-3xl font-bold p-text flex items-baseline gap-1">
                    <span class="text-lg">₹</span>{{ number_format($weeklyRevenue, 2) }}
                </div>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="p-card p-6 flex flex-col justify-between hover:shadow-[0_8px_40px_rgba(250,135,62,0.2)] transition-shadow duration-300">
            <div class="flex justify-between items-start mb-4">
                <div class="h-12 w-12 rounded-2xl bg-gradient-to-tr from-[#fa873e]/20 to-[#e06828]/20 flex items-center justify-center">
                    <i data-lucide="clock" class="w-6 h-6 text-[#e06828]"></i>
                </div>
                <span class="text-xs font-bold px-2 py-1 bg-[#10b981]/10 text-[#10b981] rounded-full uppercase tracking-wider">Today</span>
            </div>
            <div>
                <h3 class="p-label mb-1">Today's Revenue</h3>
                <div class="text-3xl font-bold p-text flex items-baseline gap-1">
                    <span class="text-lg">₹</span>{{ number_format($todayRevenue, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Analytics Chart -->
        <div class="lg:col-span-2 p-card p-6">
            <h3 class="p-label mb-6 flex items-center gap-2">
                <i data-lucide="bar-chart-3" class="w-4 h-4"></i>
                Monthly Revenue Trends
            </h3>
            <div class="h-80 w-full relative">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Revenue Breakdown & Bookings -->
        <div class="flex flex-col gap-6">
            <!-- Bookings Overview -->
            <div class="p-card p-6">
                <h3 class="p-label mb-4 flex items-center gap-2">
                    <i data-lucide="pie-chart" class="w-4 h-4"></i>
                    Bookings Overview
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-[#fa873e]/10 pb-2">
                        <span class="text-sm font-medium text-[#3e2010]/70">Total Bookings</span>
                        <span class="font-bold text-[#3e2010]">{{ $totalBookings }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#fa873e]/10 pb-2">
                        <span class="text-sm font-medium text-[#3e2010]/70">Upcoming Bookings</span>
                        <span class="font-bold text-[#3e2010]">{{ $upcomingBookings }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#fa873e]/10 pb-2">
                        <span class="text-sm font-medium text-[#3e2010]/70">Pending Payments</span>
                        <span class="font-bold text-[#fa873e]">{{ $pendingPayments }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-[#3e2010]/70">Completed Payments</span>
                        <span class="font-bold text-[#10b981]">{{ $completedPayments }}</span>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="p-card p-6 flex-1">
                <h3 class="p-label mb-4 flex items-center gap-2">
                    <i data-lucide="layers" class="w-4 h-4"></i>
                    Revenue Breakdown
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#fa873e]"></div>
                            <span class="text-sm font-medium text-[#3e2010]/70">Stay</span>
                        </div>
                        <span class="font-bold text-[#3e2010]">₹{{ number_format($stayRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#e06828]"></div>
                            <span class="text-sm font-medium text-[#3e2010]/70">Events</span>
                        </div>
                        <span class="font-bold text-[#3e2010]">₹{{ number_format($eventRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#3e2010]"></div>
                            <span class="text-sm font-medium text-[#3e2010]/70">Yachts</span>
                        </div>
                        <span class="font-bold text-[#3e2010]">₹{{ number_format($yachtRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#10b981]"></div>
                            <span class="text-sm font-medium text-[#3e2010]/70">Amenities</span>
                        </div>
                        <span class="font-bold text-[#3e2010]">₹{{ number_format($amenitiesRevenue, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#8b5cf6]"></div>
                            <span class="text-sm font-medium text-[#3e2010]/70">Food Packages</span>
                        </div>
                        <span class="font-bold text-[#3e2010]">₹{{ number_format($foodPackageRevenue, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Booking List -->
    <div class="p-card p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h3 class="p-serif text-2xl font-bold text-[#3e2010]">Revenue Records</h3>
            
            <form method="GET" action="{{ route('admin.revenue.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="p-input text-sm" placeholder="Start Date">
                    <span class="text-[#3e2010]/50">-</span>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="p-input text-sm" placeholder="End Date">
                </div>
                
                <input type="month" name="month" value="{{ request('month') }}" class="p-input text-sm w-full md:w-auto">
                
                <select name="type" class="p-input text-sm w-full md:w-auto">
                    <option value="">All Types</option>
                    <option value="stay" {{ request('type') == 'stay' ? 'selected' : '' }}>Stay</option>
                    <option value="yacht" {{ request('type') == 'yacht' ? 'selected' : '' }}>Yacht</option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                </select>
                
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="p-btn text-sm w-full md:w-auto flex-1 md:flex-none flex items-center justify-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i> Filter
                    </button>
                    @if(request()->hasAny(['start_date', 'end_date', 'month', 'type']))
                        <a href="{{ route('admin.revenue.index') }}" class="p-btn !bg-white !text-[#e06828] border border-[#e06828] text-sm flex items-center justify-center">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-[#fa873e]/20">
                        <th class="p-label py-4 pr-4">Booking ID</th>
                        <th class="p-label py-4 px-4">Guest</th>
                        <th class="p-label py-4 px-4">Property/Service</th>
                        <th class="p-label py-4 px-4">Type</th>
                        <th class="p-label py-4 px-4">Date</th>
                        <th class="p-label py-4 px-4">Status</th>
                        <th class="p-label py-4 pl-4 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#fa873e]/10">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-white/40 transition-colors">
                            <td class="py-4 pr-4 text-sm font-medium text-[#3e2010]">
                                #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="text-sm font-bold text-[#3e2010]">{{ $booking->name }}</div>
                                <div class="text-xs text-[#3e2010]/60">{{ $booking->phone }}</div>
                            </td>
                            <td class="py-4 px-4 text-sm text-[#3e2010]/80">
                                {{ $booking->property->name ?? ($booking->yacht->name ?? 'N/A') }}
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $bType = $booking->type ?? 'stay';
                                    if ($bType == 'property') $bType = 'stay';
                                @endphp
                                <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded-md
                                    @if($bType == 'yacht') bg-blue-100 text-blue-700
                                    @elseif($bType == 'event') bg-purple-100 text-purple-700
                                    @else bg-orange-100 text-orange-700 @endif
                                ">
                                    {{ $bType }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-[#3e2010]/80">
                                {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 text-xs font-bold uppercase tracking-wider rounded-md
                                    @if(in_array(strtolower($booking->payment_status), ['paid', 'completed', 'successful'])) bg-[#10b981]/10 text-[#10b981]
                                    @elseif(in_array(strtolower($booking->payment_status), ['pending'])) bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif
                                ">
                                    {{ $booking->payment_status ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="py-4 pl-4 text-right font-bold text-[#3e2010]">
                                ₹{{ number_format($booking->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-[#3e2010]/50 font-medium">
                                No revenue records found for the selected filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            // Gradient fill
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(250, 135, 62, 0.5)');   
            gradient.addColorStop(1, 'rgba(250, 135, 62, 0.0)');

            const labels = {!! json_encode($monthlyTrends['labels']) !!};
            const data = {!! json_encode($monthlyTrends['data']) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: data,
                        borderColor: '#fa873e',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#e06828',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#3e2010',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return '₹ ' + context.parsed.y.toLocaleString('en-IN');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(250, 135, 62, 0.1)',
                                drawBorder: false,
                            },
                            ticks: {
                                color: 'rgba(62, 32, 16, 0.6)',
                                font: {
                                    family: "'Outfit', sans-serif"
                                },
                                callback: function(value) {
                                    if(value >= 100000) return '₹' + (value/100000).toFixed(1) + 'L';
                                    if(value >= 1000) return '₹' + (value/1000).toFixed(1) + 'k';
                                    return '₹' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                color: 'rgba(62, 32, 16, 0.8)',
                                font: {
                                    family: "'Outfit', sans-serif",
                                    weight: '500'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>
