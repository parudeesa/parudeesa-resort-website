<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Manage Availability
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto flex flex-col" x-data="calendarManager()">
        
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                <p class="font-bold mr-2">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <div class="flex justify-between items-center bg-white p-4 rounded-xl shadow-sm border border-orange-100">
            <div>
                <h3 class="font-bold text-gray-800 p-serif text-xl">Google Calendar Integration</h3>
                <p class="text-sm text-gray-500">All bookings and blocked dates are synced here.</p>
            </div>
            <div class="flex gap-3">
                <button @click="openAddModal()" class="px-4 py-2 border-2 border-[#e06828] text-[#e06828] font-bold rounded-lg hover:bg-orange-50 transition-colors shadow-sm flex items-center">
                    <i data-lucide="calendar-plus" class="w-4 h-4 mr-2"></i> Manage Availability
                </button>
                <a href="https://calendar.google.com/calendar/u/0/r?cid={{ env('GOOGLE_CALENDAR_ID') }}" target="_blank" class="p-btn whitespace-nowrap flex items-center">
                    <i data-lucide="external-link" class="w-4 h-4 mr-2"></i> Open in Google
                </a>
            </div>
        </div>

        <div class="p-card h-[500px] overflow-hidden relative">
            @if(env('GOOGLE_CALENDAR_ID'))
                <iframe src="https://calendar.google.com/calendar/embed?src={{ urlencode(env('GOOGLE_CALENDAR_ID')) }}&ctz={{ urlencode(config('app.timezone', 'Asia/Kolkata')) }}&bgcolor=%23ffffff&color=%23fa873e" style="border: 0" width="100%" height="100%" frameborder="0" scrolling="no" class="absolute inset-0"></iframe>
            @else
                <div class="flex flex-col items-center justify-center h-full text-center p-8">
                    <i data-lucide="calendar-off" class="w-16 h-16 text-gray-300 mb-4"></i>
                    <h3 class="text-2xl p-serif font-bold text-gray-700 mb-2">Calendar Not Configured</h3>
                    <p class="text-gray-500 mb-6 max-w-md">Please configure your Google Calendar ID in the .env file to view the embedded calendar.</p>
                    <code class="bg-gray-100 px-4 py-2 rounded text-sm text-pink-600">GOOGLE_CALENDAR_ID=your_calendar_id@group.calendar.google.com</code>
                </div>
            @endif
        </div>

        <!-- Manage Availability Section -->
        <div class="p-card p-6 sm:p-8">
            <h3 class="font-bold text-gray-800 p-serif text-xl border-b pb-3 mb-6" style="border-color:rgba(250,135,62,.15)">
                Manage Availability (Blocks & Reservations)
            </h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                    <thead style="background:rgba(250,135,62,.05)">
                        <tr>
                            <th class="px-6 py-4 text-left p-label rounded-tl-lg">Event</th>
                            <th class="px-6 py-4 text-left p-label">Property</th>
                            <th class="px-6 py-4 text-left p-label">Dates</th>
                            <th class="px-6 py-4 text-left p-label">Type</th>
                            <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                        @forelse($events as $event)
                        <tr class="hover:bg-orange-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold p-text text-md">{{ $event->display_name }}</div>
                                <div class="text-xs text-gray-500 truncate max-w-xs">{{ $event->notes }}</div>
                                @if(!$event->is_block)
                                    <div class="text-xs text-gray-400">{{ $event->phone }} | ₹{{ $event->amount }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $event->property->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                <div><span class="font-semibold p-text">In:</span> {{ $event->start_date->format('M d, Y') }}</div>
                                <div><span class="font-semibold p-text">Out:</span> {{ $event->end_date->format('M d, Y') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                                    @if($event->is_block) bg-red-100 text-red-800
                                    @else bg-green-100 text-green-800 @endif">
                                    {{ $event->display_type }}
                                </span>
                                @if(!$event->is_block)
                                    <div class="mt-1 text-[10px] uppercase font-bold @if($event->payment_status == 'Paid') text-green-600 @else text-orange-500 @endif">
                                        {{ $event->payment_status }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    @if($event->is_block)
                                        <button @click="openEditBlockModal({{ $event->id }}, '{{ $event->property_id }}', '{{ $event->reason }}', '{{ $event->start_date->format('Y-m-d') }}', '{{ $event->end_date->format('Y-m-d') }}', '{{ addslashes($event->notes ?? '') }}')" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="Edit Block">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button @click="openDeleteModal('{{ route('admin.calendar.destroy_block', $event->id) }}', '{{ addslashes($event->display_name) }}')" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Delete Block">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    @else
                                        <button @click="openEditReservationModal({{ $event->id }}, '{{ $event->property_id }}', '{{ addslashes($event->name) }}', '{{ addslashes($event->phone ?? '') }}', '{{ $event->start_date->format('Y-m-d') }}', '{{ $event->end_date->format('Y-m-d') }}', '{{ $event->amount }}', '{{ $event->payment_status }}', '{{ addslashes($event->notes ?? '') }}', {{ $event->guests ?? 1 }}, '{{ $event->package_name ?? 'Only Stay' }}', {{ json_encode($event->amenities ?? []) }})" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="Edit Reservation">
                                            <i data-lucide="pencil" class="w-4 h-4"></i>
                                        </button>
                                        <button @click="openDeleteModal('{{ route('admin.calendar.destroy_reservation', $event->id) }}', '{{ addslashes($event->display_name) }}')" class="bg-red-50 hover:bg-red-100 text-red-600 p-2 rounded-lg transition-colors" title="Delete Reservation">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center p-text italic flex-col items-center justify-center">
                                <i data-lucide="calendar-x" class="w-12 h-12 text-orange-200 mx-auto mb-3"></i>
                                No blocked dates or manual reservations found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add/Edit Modal (Tabbed) -->
        <div x-show="isModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full p-8" @click.away="closeModal()">
                    
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-2xl p-serif font-bold p-text flex items-center" x-text="isEditMode ? (activeTab === 'block' ? 'Edit Blocked Date' : 'Edit Reservation') : 'Manage Availability'">
                        </h3>
                        <button @click="closeModal()" class="text-gray-400 hover:text-red-500 transition-colors">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <!-- Tabs -->
                    <div class="flex border-b mb-6" x-show="!isEditMode">
                        <button @click="activeTab = 'block'" :class="{'border-b-2 border-[#e06828] text-[#e06828] font-bold': activeTab === 'block', 'text-gray-500 hover:text-gray-700': activeTab !== 'block'}" class="px-4 py-3 text-sm transition-colors uppercase tracking-wide">
                            Block Dates
                        </button>
                        <button @click="activeTab = 'reservation'" :class="{'border-b-2 border-[#e06828] text-[#e06828] font-bold': activeTab === 'reservation', 'text-gray-500 hover:text-gray-700': activeTab !== 'reservation'}" class="px-4 py-3 text-sm transition-colors uppercase tracking-wide">
                            Add Reservation
                        </button>
                    </div>

                    <!-- Block Dates Form -->
                    <form x-show="activeTab === 'block'" :action="formActionBlock" method="POST" class="space-y-4">
                        @csrf
                        <template x-if="isEditMode">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-1">Property *</label>
                                <select name="property_id" x-model="formData.property_id" required class="p-input">
                                    <option value="" disabled>Select Property...</option>
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="p-label block mb-1">Reason *</label>
                                <select name="reason" x-model="formData.reason" required class="p-input">
                                    <option value="" disabled>Select Reason...</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Owner Stay">Owner Stay</option>
                                    <option value="Private Use">Private Use</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-1">Start Date *</label>
                                <input type="date" name="start_date" x-model="formData.start_date" required class="p-input">
                            </div>
                            <div>
                                <label class="p-label block mb-1">End Date *</label>
                                <input type="date" name="end_date" x-model="formData.end_date" required class="p-input">
                            </div>
                        </div>

                        <div>
                            <label class="p-label block mb-1">Notes (Optional)</label>
                            <textarea name="notes" x-model="formData.notes" class="p-input" rows="2" placeholder="Internal admin notes..."></textarea>
                        </div>

                        <div class="flex space-x-3 pt-4 border-t border-orange-100 mt-6">
                            <button type="button" @click="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 p-btn" x-text="isEditMode ? 'Update Block' : 'Save Block'">
                            </button>
                        </div>
                    </form>

                    <!-- Add Reservation Form -->
                    <form x-show="activeTab === 'reservation'" :action="formActionReservation" method="POST" class="space-y-4" x-cloak>
                        @csrf
                        <template x-if="isEditMode">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>

                        <div>
                            <label class="p-label block mb-1">Property *</label>
                            <select name="property_id" x-model="formData.property_id" required class="p-input">
                                <option value="" disabled>Select Property...</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-1">Guest Name *</label>
                                <input type="text" name="name" x-model="formData.name" required class="p-input" placeholder="Guest Name" minlength="3" maxlength="255">
                            </div>
                            <div>
                                <label class="p-label block mb-1">Phone Number (Optional)</label>
                                <input type="text" name="phone" x-model="formData.phone" class="p-input" placeholder="Phone" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" title="Please enter a 10-digit phone number.">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-1">Start Date *</label>
                                <input type="date" name="check_in" x-model="formData.start_date" required class="p-input">
                            </div>
                            <div>
                                <label class="p-label block mb-1">End Date *</label>
                                <input type="date" name="check_out" x-model="formData.end_date" required class="p-input">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="p-label block mb-1">Number of Guests *</label>
                                <input type="number" name="guests" x-model="formData.guests" min="1" required class="p-input">
                            </div>
                            <div>
                                <label class="p-label block mb-1">Food Package</label>
                                <select name="package_name" x-model="formData.package_name" class="p-input">
                                    <option value="Only Stay">Only Stay</option>
                                    @foreach($foodPackages as $pkg)
                                        @if(!str_contains(strtolower($pkg->name), 'only'))
                                            <option value="{{ $pkg->name }}">{{ $pkg->name }} (+₹{{ number_format($pkg->price, 0) }}/person)</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="p-label block mb-2">Amenities</label>
                            <div class="space-y-3 max-h-48 overflow-y-auto p-3 border rounded-lg" style="border-color:rgba(250,135,62,.15); background:rgba(250,135,62,.02);">
                                @foreach($amenities as $amenity)
                                    @php
                                        $amenityNameLower = strtolower($amenity->name);
                                        $isPerPerson = (str_contains($amenityNameLower, 'sheesha') || str_contains($amenityNameLower, 'kayak') || str_contains($amenityNameLower, 'boating') || $amenity->pricing_type === 'per_person');
                                        $isAutoGuest = (str_contains($amenityNameLower, 'campfire') || str_contains($amenityNameLower, 'camp fire') || str_contains($amenityNameLower, 'speaker') || str_contains($amenityNameLower, 'yacht'));
                                    @endphp
                                    <div class="flex flex-col gap-2 p-2 bg-white rounded shadow-sm border border-orange-50">
                                        <div class="flex items-start justify-between">
                                            <label class="flex items-center gap-2 cursor-pointer">
                                                <input type="checkbox" x-model="formData.amenities[{{ $amenity->id }}].selected" class="rounded border-orange-300 text-orange-500 focus:ring-orange-500">
                                                <span class="text-sm font-semibold text-gray-700">{{ $amenity->name }}</span>
                                            </label>
                                            <span class="text-sm font-bold text-orange-500" x-text="getAmenityDisplayPrice('{{ $amenity->id }}')">
                                                @if(str_contains($amenityNameLower, 'kayaking') || str_contains($amenityNameLower, 'boating'))
                                                    ₹{{ number_format($bookingSettings['water_activity_high_price'] ?? 700, 0) }}/p
                                                @else
                                                    ₹{{ number_format($amenity->price, 0) }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                        @if($isPerPerson && !$isAutoGuest)
                                        <div x-show="formData.amenities[{{ $amenity->id }}].selected" class="flex items-center justify-between pl-6 mt-1 border-t border-dashed border-orange-100 pt-2" x-cloak>
                                            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Guests/Units</span>
                                            <div class="flex items-center border border-orange-200 rounded-md overflow-hidden bg-white">
                                                <button type="button" @click="if(formData.amenities[{{ $amenity->id }}].participants > 1) formData.amenities[{{ $amenity->id }}].participants--" class="px-2 py-1 bg-orange-50 hover:bg-orange-100 text-orange-600 font-bold">-</button>
                                                <input type="number" readonly x-model="formData.amenities[{{ $amenity->id }}].participants" class="w-10 text-center border-none text-sm font-bold p-0 focus:ring-0">
                                                <button type="button" @click="formData.amenities[{{ $amenity->id }}].participants++" class="px-2 py-1 bg-orange-50 hover:bg-orange-100 text-orange-600 font-bold">+</button>
                                            </div>
                                        </div>
                                        @endif
                                        <!-- Hidden Inputs to submit data properly -->
                                        <input type="hidden" :name="`amenities[${{{ $amenity->id }}}][selected]`" :value="formData.amenities[{{ $amenity->id }}].selected ? 1 : 0">
                                        <input type="hidden" :name="`amenities[${{{ $amenity->id }}}][participants]`" :value="formData.amenities[{{ $amenity->id }}].participants">
                                        <input type="hidden" :name="`amenities[${{{ $amenity->id }}}][id]`" value="{{ $amenity->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Booking Summary & Total -->
                        <div class="p-4 bg-orange-50/50 rounded-xl border border-orange-100 mt-4">
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide mb-3 flex items-center gap-2">
                                <i data-lucide="receipt" class="w-4 h-4 text-orange-500"></i> Reservation Summary
                            </h4>
                            <div class="space-y-2 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Stay (<span x-text="bookingNights"></span> nights)</span>
                                    <span class="font-semibold" x-text="'₹' + stayTotal.toLocaleString('en-IN')"></span>
                                </div>
                                <div class="flex justify-between" x-show="packageTotal > 0">
                                    <span x-text="formData.package_name + ' Package'"></span>
                                    <span class="font-semibold" x-text="'₹' + packageTotal.toLocaleString('en-IN')"></span>
                                </div>
                                <div class="flex justify-between" x-show="amenitiesTotal > 0">
                                    <span>Amenities & Add-ons</span>
                                    <span class="font-semibold" x-text="'₹' + amenitiesTotal.toLocaleString('en-IN')"></span>
                                </div>
                                <div class="flex justify-between border-t border-orange-200 pt-2 mt-2">
                                    <span class="font-bold text-gray-800">Calculated Total</span>
                                    <span class="font-bold text-orange-600 text-lg" x-text="'₹' + grandTotal.toLocaleString('en-IN')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <label class="p-label block mb-1">Override Amount (Optional)</label>
                                <input type="number" name="amount" x-model="formData.amount" class="p-input" placeholder="Leave blank to use calculated total">
                                <p class="text-[10px] text-gray-400 mt-1">If left empty, ₹<span x-text="grandTotal"></span> will be used.</p>
                            </div>
                            <div>
                                <label class="p-label block mb-1">Payment Status *</label>
                                <select name="payment_status" x-model="formData.payment_status" required class="p-input">
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="p-label block mb-1">Notes (Optional)</label>
                            <textarea name="notes" x-model="formData.notes" class="p-input" rows="2" placeholder="Internal admin notes..."></textarea>
                        </div>

                        <div class="flex space-x-3 pt-4 border-t border-orange-100 mt-6">
                            <button type="button" @click="closeModal()" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 p-btn" x-text="isEditMode ? 'Update Reservation' : 'Save Reservation'">
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="isDeleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                <div x-show="isDeleteModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="isDeleteModalOpen" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full p-8 text-center" @click.away="isDeleteModalOpen = false">
                    
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                        <i data-lucide="alert-triangle" class="h-8 w-8 text-red-600"></i>
                    </div>
                    
                    <h3 class="text-xl font-bold p-text mb-2 p-serif">Confirm Deletion</h3>
                    <p class="text-gray-500 mb-6">Are you sure you want to delete <span class="font-bold text-gray-800" x-text="deleteEventName"></span>? This will also remove it from Google Calendar.</p>
                    
                    <form :action="deleteFormAction" method="POST" class="flex space-x-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="isDeleteModalOpen = false" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition-colors shadow-lg uppercase text-sm tracking-wider">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Alpine Component Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('calendarManager', () => ({
                isModalOpen: false,
                isEditMode: false,
                activeTab: 'block', // 'block' or 'reservation'
                formActionBlock: '{{ route('admin.calendar.store_block') }}',
                formActionReservation: '{{ route('admin.calendar.store_reservation') }}',
                formData: {
                    property_id: '',
                    reason: '', // for block
                    name: '', // for reservation
                    phone: '', // for reservation
                    start_date: '',
                    end_date: '',
                    guests: 1,
                    package_name: 'Only Stay',
                    amenities: {
                        @foreach($amenities as $amenity)
                        {{ $amenity->id }}: { selected: false, participants: 1 },
                        @endforeach
                    },
                    amount: '',
                    payment_status: 'Pending',
                    notes: ''
                },
                isDeleteModalOpen: false,
                deleteFormAction: '',
                deleteEventName: '',

                openAddModal() {
                    this.isEditMode = false;
                    this.activeTab = 'block';
                    this.formActionBlock = '{{ route('admin.calendar.store_block') }}';
                    this.formActionReservation = '{{ route('admin.calendar.store_reservation') }}';
                    this.resetForm();
                    this.isModalOpen = true;
                },

                openEditBlockModal(id, property_id, reason, start_date, end_date, notes) {
                    this.isEditMode = true;
                    this.activeTab = 'block';
                    this.formActionBlock = `/calendar/blocks/${id}`;
                    this.resetForm();
                    this.formData.property_id = property_id;
                    this.formData.reason = reason;
                    this.formData.start_date = start_date;
                    this.formData.end_date = end_date;
                    this.formData.notes = notes;
                    this.isModalOpen = true;
                },

                openEditReservationModal(id, property_id, name, phone, start_date, end_date, amount, payment_status, notes, guests, package_name, savedAmenities) {
                    this.isEditMode = true;
                    this.activeTab = 'reservation';
                    this.formActionReservation = `/calendar/reservations/${id}`;
                    this.resetForm();
                    this.formData.property_id = property_id;
                    this.formData.name = name;
                    this.formData.phone = phone;
                    this.formData.start_date = start_date;
                    this.formData.end_date = end_date;
                    this.formData.amount = amount;
                    this.formData.payment_status = payment_status || 'Pending';
                    this.formData.notes = notes;
                    this.formData.guests = guests || 1;
                    this.formData.package_name = package_name || 'Only Stay';
                    
                    if (savedAmenities && Array.isArray(savedAmenities)) {
                        savedAmenities.forEach(a => {
                            if (this.formData.amenities[a.id]) {
                                this.formData.amenities[a.id].selected = true;
                                this.formData.amenities[a.id].participants = a.quantity || 1;
                            }
                        });
                    }
                    this.isModalOpen = true;
                },

                resetForm() {
                    this.formData = {
                        property_id: '',
                        reason: '',
                        name: '',
                        phone: '',
                        start_date: '',
                        end_date: '',
                        guests: 1,
                        package_name: 'Only Stay',
                        amenities: {
                            @foreach($amenities as $amenity)
                            {{ $amenity->id }}: { selected: false, participants: 1 },
                            @endforeach
                        },
                        amount: '',
                        payment_status: 'Pending',
                        notes: ''
                    };
                },

                closeModal() {
                    this.isModalOpen = false;
                },

                openDeleteModal(actionUrl, name) {
                    this.deleteFormAction = actionUrl;
                    this.deleteEventName = name;
                    this.isDeleteModalOpen = true;
                },

                // Getters for Dynamic Pricing
                get propertyPricing() {
                    const propertiesData = @json($properties->keyBy('id')->map(function($p) {
                        return [
                            'weekday' => (float)($p->weekday_price ?: $p->price),
                            'weekday_tier2' => (float)($p->weekday_tier2_price ?: ($p->weekday_price ?: $p->price)),
                            'weekend' => (float)($p->weekend_price ?: $p->price)
                        ];
                    }));
                    return propertiesData[this.formData.property_id] || { weekday: 8000, weekday_tier2: 11000, weekend: 12000 };
                },

                get bookingNights() {
                    if (!this.formData.start_date || !this.formData.end_date) return 0;
                    const start = new Date(this.formData.start_date + 'T00:00');
                    const end = new Date(this.formData.end_date + 'T00:00');
                    const diffTime = end - start;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    return diffDays > 0 ? diffDays : 0;
                },

                get stayTotal() {
                    if (!this.formData.property_id || this.bookingNights <= 0) return 0;
                    let total = 0;
                    const guests = parseInt(this.formData.guests) || 1;
                    const stayThreshold = {{ $bookingSettings['property_stay_threshold'] ?? 5 }};
                    const start = new Date(this.formData.start_date + 'T00:00');
                    
                    for (let i = 0; i < this.bookingNights; i++) {
                        const curr = new Date(start);
                        curr.setDate(start.getDate() + i);
                        const isWeekend = [5, 6, 0].includes(curr.getDay()); 
                        
                        if (isWeekend) {
                            total += this.propertyPricing.weekend;
                        } else {
                            if (guests <= stayThreshold) {
                                total += this.propertyPricing.weekday;
                            } else {
                                total += this.propertyPricing.weekday_tier2;
                            }
                        }
                    }
                    return total;
                },

                get packageTotal() {
                    if (this.formData.package_name === 'Only Stay' || this.bookingNights <= 0) return 0;
                    const packagesData = @json($foodPackages->keyBy('name')->map(fn($p) => (float)$p->price));
                    const pricePerPerson = packagesData[this.formData.package_name] || 0;
                    const guests = parseInt(this.formData.guests) || 1;
                    return pricePerPerson * guests * this.bookingNights;
                },

                get amenitiesTotal() {
                    let total = 0;
                    const amenitiesData = @json($amenities->keyBy('id'));
                    
                    for (const [id, state] of Object.entries(this.formData.amenities)) {
                        if (state.selected) {
                            const amenity = amenitiesData[id];
                            if (!amenity) continue;
                            
                            const nameLower = amenity.name.toLowerCase();
                            let price = parseFloat(amenity.price);
                            const participants = parseInt(state.participants) || 1;
                            
                            if (nameLower.includes('kayaking') || nameLower.includes('boating')) {
                                const waterThreshold = {{ $bookingSettings['water_activity_threshold'] ?? 5 }};
                                const waterLow = {{ $bookingSettings['water_activity_low_price'] ?? 1000 }};
                                const waterHigh = {{ $bookingSettings['water_activity_high_price'] ?? 700 }};
                                price = participants < waterThreshold ? waterLow : waterHigh;
                            }
                            
                            const isPerPerson = nameLower.includes('sheesha') || nameLower.includes('kayak') || nameLower.includes('boating') || amenity.pricing_type === 'per_person';
                            const isAutoGuest = nameLower.includes('campfire') || nameLower.includes('speaker') || nameLower.includes('yacht');
                            
                            if (isPerPerson && !isAutoGuest) {
                                total += price * participants;
                            } else if (isAutoGuest) {
                                total += price;
                            } else {
                                total += price;
                            }
                        }
                    }
                    return total;
                },

                getAmenityDisplayPrice(id) {
                    const amenitiesData = @json($amenities->keyBy('id'));
                    const amenity = amenitiesData[id];
                    if (!amenity) return '';
                    
                    const nameLower = amenity.name.toLowerCase();
                    let price = parseFloat(amenity.price);
                    const state = this.formData.amenities[id];
                    const participants = state ? (parseInt(state.participants) || 1) : 1;

                    if (nameLower.includes('kayaking') || nameLower.includes('boating')) {
                        const waterThreshold = {{ $bookingSettings['water_activity_threshold'] ?? 5 }};
                        const waterLow = {{ $bookingSettings['water_activity_low_price'] ?? 1000 }};
                        const waterHigh = {{ $bookingSettings['water_activity_high_price'] ?? 700 }};
                        price = participants < waterThreshold ? waterLow : waterHigh;
                        return '₹' + price.toLocaleString('en-IN') + '/p';
                    }
                    
                    if (nameLower.includes('sheesha') || amenity.pricing_type === 'per_person') {
                         return '₹' + price.toLocaleString('en-IN') + '/unit';
                    }

                    return '₹' + price.toLocaleString('en-IN');
                },

                get grandTotal() {
                    return this.stayTotal + this.packageTotal + this.amenitiesTotal;
                }
            }));
        });
    </script>
</x-admin-layout>
