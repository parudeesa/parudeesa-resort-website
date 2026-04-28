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
                                        <button @click="openEditReservationModal({{ $event->id }}, '{{ $event->property_id }}', '{{ addslashes($event->name) }}', '{{ addslashes($event->phone ?? '') }}', '{{ $event->start_date->format('Y-m-d') }}', '{{ $event->end_date->format('Y-m-d') }}', '{{ $event->amount }}', '{{ $event->payment_status }}', '{{ addslashes($event->notes ?? '') }}')" class="bg-blue-50 hover:bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="Edit Reservation">
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
                                <input type="text" name="name" x-model="formData.name" required class="p-input" placeholder="Guest Name">
                            </div>
                            <div>
                                <label class="p-label block mb-1">Phone Number (Optional)</label>
                                <input type="text" name="phone" x-model="formData.phone" class="p-input" placeholder="Phone">
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
                                <label class="p-label block mb-1">Total Amount (Optional)</label>
                                <input type="number" name="amount" x-model="formData.amount" class="p-input" placeholder="0.00">
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

                openEditReservationModal(id, property_id, name, phone, start_date, end_date, amount, payment_status, notes) {
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
                }
            }));
        });
    </script>
</x-admin-layout>
