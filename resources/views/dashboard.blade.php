<x-app-layout>
    <x-slot name="header">
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600;1,700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Josefin+Sans:wght@300;400;600&display=swap" rel="stylesheet"/>
        <style>
            .parudeesa-bg { background-color: #fff3ec !important; font-family: 'Josefin Sans', sans-serif !important; }
            .p-serif { font-family: 'Cormorant Garamond', serif !important; }
            .p-card { background: #fff8f3; border: 1px solid rgba(250,135,62,.15); box-shadow: 0 6px 32px rgba(250,135,62,.15); border-radius: 16px; }
            .p-btn { background: linear-gradient(135deg, #fa873e, #e06828); color: white; border: none; padding: 0.6rem 1.5rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.08em; border-radius: 8px; box-shadow: 0 4px 18px rgba(250,135,62,.35); transition: transform 0.3s ease; }
            .p-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(250,135,62,.45); color: white; }
            .p-input { border: 1.5px solid rgba(250,135,62,.25); border-radius: 8px; padding: 0.5rem 1rem; width: 100%; box-shadow: none !important; }
            .p-input:focus { border-color: #e06828; outline: none; }
            .p-label { color: #e06828; font-weight: 700; font-size: 0.75rem; letter-spacing: 0.1em; text-transform: uppercase; }
            .p-text { color: #3e2010; }
        </style>
        
        <h2 class="p-serif font-semibold text-3xl" style="color:#e06828;">
            ✦ Parudeesa Super Admin ✦
        </h2>
    </x-slot>

    <div class="py-12 parudeesa-bg min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg shadow-sm" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Add Property Card -->
            <div class="p-card overflow-hidden p-8">
                <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Add New Property</h3>
                <form action="{{ route('property.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="p-label">Property Name</label>
                        <input id="name" name="name" type="text" class="p-input mt-1" placeholder="e.g. Parudeesa Utopiya" required />
                    </div>
                    <div>
                        <label class="p-label">Description</label>
                        <textarea id="description" name="description" class="p-input mt-1" rows="3" placeholder="Features and details..." required></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="p-label">Price (in INR)</label>
                            <input id="price" name="price" type="number" step="0.01" class="p-input mt-1" placeholder="5000" required />
                        </div>
                        <div>
                            <label class="p-label">Location</label>
                            <input id="location" name="location" type="text" class="p-input mt-1" placeholder="Kerala, India" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="p-label">WhatsApp Number</label>
                            <input id="phone" name="phone" type="text" class="p-input mt-1" placeholder="918921021202" />
                        </div>
                        <div>
                            <label class="p-label">Cover Image URL</label>
                            <input id="image_url" name="image_url" type="url" class="p-input mt-1" placeholder="https://unsplash.com/..." />
                        </div>
                    </div>
                    <div class="pt-5 mt-5 border-t" style="border-color:rgba(250,135,62,.15)">
                        <button type="submit" class="p-btn w-full sm:w-auto">Confirm & Save Property</button>
                    </div>
                </form>
            </div>

            <!-- List Properties Card -->
            <div class="p-card overflow-hidden p-8">
                <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Existing Properties</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                        <thead style="background:rgba(250,135,62,.05)">
                            <tr>
                                <th class="px-6 py-4 text-left p-label">Name</th>
                                <th class="px-6 py-4 text-left p-label">Location</th>
                                <th class="px-6 py-4 text-left p-label">Price</th>
                                <th class="px-6 py-4 text-right p-label">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="border-color:rgba(250,135,62,.15)">
                            @foreach(App\Models\Property::all() as $property)
                            <tr class="hover:bg-orange-50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap text-md font-bold p-text"><span class="p-serif text-lg">{{ $property->name }}</span></td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm p-text">{{ $property->location }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm font-semibold" style="color:#e06828">₹{{ number_format($property->price, 2) }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm">
                                    <form action="{{ route('property.delete', $property->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to securely delete {{ $property->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white px-4 py-2 rounded-lg shadow-sm font-bold tracking-wide text-xs uppercase" style="background:#d9534f; transition:transform 0.2s" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(App\Models\Property::count() == 0)
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-md p-text font-serif italic">No properties officially added yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Amenities Management Card -->
            <div class="p-card overflow-hidden p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="p-serif text-2xl font-bold border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Amenities Management</h3>
                    <a href="{{ route('amenities.index') }}" class="p-btn">
                        <i class="bi bi-gear mr-2"></i>Manage Amenities
                    </a>
                </div>
                <p class="p-text">Add, edit, and manage property amenities that can be assigned to properties.</p>
            </div>

            <!-- Booking Calendar Card -->
            <div class="p-card overflow-hidden p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="p-serif text-2xl font-bold border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Booking Calendar</h3>
                    <a href="https://calendar.google.com/calendar/u/0/r?cid={{ env('GOOGLE_CALENDAR_ID') }}" target="_blank" class="p-btn">
                        <i class="bi bi-calendar mr-2"></i>Open Calendar
                    </a>
                </div>
                <p class="p-text">View and manage all bookings in Google Calendar. New bookings are automatically synced.</p>
            </div>

            <!-- Recent Bookings Card -->
            <div class="p-card overflow-hidden p-8">
                <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3" style="color:#3e2010; border-color:rgba(250,135,62,.15)">Recent Bookings</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                        <thead style="background:rgba(250,135,62,.05)">
                            <tr>
                                <th class="px-6 py-4 text-left p-label">Customer</th>
                                <th class="px-6 py-4 text-left p-label">Property</th>
                                <th class="px-6 py-4 text-left p-label">Check-in</th>
                                <th class="px-6 py-4 text-left p-label">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="border-color:rgba(250,135,62,.15)">
                            @foreach(App\Models\Booking::with('property')->latest()->take(10)->get() as $booking)
                            <tr class="hover:bg-orange-50 transition-colors">
                                <td class="px-6 py-5 whitespace-nowrap text-md font-bold p-text">{{ $booking->name }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm p-text">{{ $booking->property->name }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm p-text">{{ $booking->check_in->format('M d, Y') }}</td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm">
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
                                <td colspan="4" class="px-6 py-12 text-center text-md p-text font-serif italic">No bookings yet.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>