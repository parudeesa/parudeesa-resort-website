<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.events.index') }}" class="text-gray-500 hover:text-[#e06828] transition-colors">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
                Inquiry Details: {{ $inquiry->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Inquiry Content -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="p-card p-8">
                        <div class="flex justify-between items-start mb-8">
                            <div>
                                <span class="p-label">Event Vision</span>
                                <h3 class="text-3xl font-bold p-serif text-[#3e2010] mt-1">{{ $inquiry->event_type }}</h3>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-400 uppercase tracking-widest">Received On</span>
                                <p class="font-semibold text-gray-700">{{ $inquiry->created_at->format('M d, Y • h:i A') }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 mb-10">
                            <div>
                                <span class="p-label block mb-1">Event Date</span>
                                <p class="font-bold text-lg text-[#3e2010]">{{ \Carbon\Carbon::parse($inquiry->event_date)->format('D, M d, Y') }}</p>
                            </div>
                            <div>
                                <span class="p-label block mb-1">Event Time</span>
                                <p class="font-bold text-lg text-[#3e2010]">{{ $inquiry->event_time ?: 'Not Specified' }}</p>
                            </div>
                            <div>
                                <span class="p-label block mb-1">Guests Count</span>
                                <p class="font-bold text-lg text-[#3e2010]">{{ $inquiry->guests }} People</p>
                            </div>
                            <div>
                                <span class="p-label block mb-1">Budget Range</span>
                                <p class="font-bold text-lg text-[#e06828]">{{ $inquiry->budget ?: 'Not Specified' }}</p>
                            </div>
                        </div>

                        @if($inquiry->need_stay === 'Yes')
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6 mb-10">
                            <h4 class="font-bold text-blue-900 flex items-center mb-4">
                                <i data-lucide="moon-stars" class="w-5 h-5 mr-2"></i> Accommodation Requested
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                                <div>
                                    <span class="text-xs text-blue-600 uppercase font-bold tracking-wider">Staying Guests</span>
                                    <p class="font-bold text-blue-900 text-lg">{{ $inquiry->stay_guests }} Guests</p>
                                </div>
                                <div>
                                    <span class="text-xs text-blue-600 uppercase font-bold tracking-wider">Check-in</span>
                                    <p class="font-bold text-blue-900">{{ $inquiry->check_in ? \Carbon\Carbon::parse($inquiry->check_in)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-blue-600 uppercase font-bold tracking-wider">Check-out</span>
                                    <p class="font-bold text-blue-900">{{ $inquiry->check_out ? \Carbon\Carbon::parse($inquiry->check_out)->format('M d, Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mb-10">
                            <span class="p-label block mb-3">Custom Requirements</span>
                            <div class="flex flex-wrap gap-2">
                                @if($inquiry->requirements)
                                    @foreach($inquiry->requirements as $req)
                                    <span class="px-4 py-2 bg-orange-50 text-[#e06828] border border-orange-100 rounded-xl text-sm font-semibold">
                                        {{ $req }}
                                    </span>
                                    @endforeach
                                @else
                                    <p class="text-gray-400 italic">No specific requirements selected.</p>
                                @endif
                            </div>
                        </div>

                        <div>
                            <span class="p-label block mb-3">Additional Notes & Vision</span>
                            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 text-gray-700 leading-relaxed italic">
                                "{!! nl2br(e($inquiry->notes)) ?: 'No additional notes provided.' !!}"
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Guest Info & Actions -->
                <div class="space-y-8">
                    <div class="p-card p-6">
                        <h4 class="font-bold p-serif text-xl mb-6 border-b border-orange-100 pb-3">Guest Contact</h4>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828] mr-4">
                                    <i data-lucide="user" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Full Name</p>
                                    <p class="font-bold text-[#3e2010]">{{ $inquiry->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828] mr-4">
                                    <i data-lucide="phone" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Phone Number</p>
                                    <a href="tel:{{ $inquiry->phone }}" class="font-bold text-[#e06828] hover:underline">{{ $inquiry->phone }}</a>
                                </div>
                            </div>
                            @if($inquiry->email)
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-[#e06828] mr-4">
                                    <i data-lucide="mail" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Email Address</p>
                                    <a href="mailto:{{ $inquiry->email }}" class="font-bold text-[#e06828] hover:underline">{{ $inquiry->email }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="p-card p-6">
                        <h4 class="font-bold p-serif text-xl mb-6 border-b border-orange-100 pb-3">Status Management</h4>
                        <form action="{{ route('admin.events.update_status', $inquiry->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-4">
                                <label class="p-label mb-2 block">Inquiry Status</label>
                                <select name="status" class="p-input bg-white" onchange="this.form.submit()">
                                    <option value="pending" {{ $inquiry->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="responded" {{ $inquiry->status == 'responded' ? 'selected' : '' }}>Responded</option>
                                    <option value="confirmed" {{ $inquiry->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="cancelled" {{ $inquiry->status == 'cancelled' ? 'selected' : '' }}>Cancelled / Archived</option>
                                </select>
                            </div>
                            <p class="text-xs text-gray-500 italic">Updating the status helps your team track the communication progress with this guest.</p>
                        </form>
                    </div>

                    <div class="flex gap-4">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $inquiry->phone) }}" target="_blank" class="flex-1 p-btn text-center flex items-center justify-center gap-2" style="background: #25D366; box-shadow: 0 4px 18px rgba(37,211,102,.3);">
                            <i data-lucide="message-circle" class="w-5 h-5"></i> WhatsApp
                        </a>
                        <a href="tel:{{ $inquiry->phone }}" class="flex-1 p-btn text-center flex items-center justify-center gap-2">
                            <i data-lucide="phone-call" class="w-5 h-5"></i> Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
