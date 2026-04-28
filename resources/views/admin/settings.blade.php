<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            System Settings
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <div class="p-card p-6 sm:p-8">
            <div class="mb-8 border-b pb-4" style="border-color:rgba(250,135,62,.15)">
                <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                    <i data-lucide="settings-2" class="w-6 h-6 mr-2 text-[#e06828]"></i> General Configuration
                </h3>
                <p class="text-gray-500 mt-1">Manage core settings for the Parudeesa Resort website.</p>
            </div>

            <form action="#" method="POST" class="space-y-8">
                @csrf

                <!-- Site Information -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-800 text-lg border-l-4 border-[#e06828] pl-3">Site Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-4">
                        <div>
                            <label class="p-label">Resort Name</label>
                            <input type="text" class="p-input mt-1" value="Parudeesa Resort" />
                        </div>
                        <div>
                            <label class="p-label">Contact Email</label>
                            <input type="email" class="p-input mt-1" value="admin@parudeesa.com" />
                        </div>
                        <div>
                            <label class="p-label">Phone Number</label>
                            <input type="text" class="p-input mt-1" value="+91 98765 43210" />
                        </div>
                        <div>
                            <label class="p-label">Support WhatsApp</label>
                            <input type="text" class="p-input mt-1" value="919876543210" />
                        </div>
                    </div>
                </div>

                <!-- Integrations -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-800 text-lg border-l-4 border-[#e06828] pl-3">Integrations</h4>
                    <div class="grid grid-cols-1 gap-6 pl-4">
                        <div>
                            <label class="p-label">Google Calendar ID</label>
                            <input type="text" class="p-input mt-1 font-mono text-sm" value="{{ env('GOOGLE_CALENDAR_ID', '') }}" placeholder="xxx@group.calendar.google.com" />
                            <p class="text-xs text-gray-500 mt-1">Used for syncing booking reservations.</p>
                        </div>
                        <div>
                            <label class="p-label">Payment Gateway API Key (Razorpay)</label>
                            <input type="password" class="p-input mt-1 font-mono text-sm" value="rzp_test_xxxxxx" />
                        </div>
                    </div>
                </div>

                <!-- Theme Preferences -->
                <div class="space-y-4">
                    <h4 class="font-bold text-gray-800 text-lg border-l-4 border-[#e06828] pl-3">Theme Preferences</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-4">
                        <div>
                            <label class="p-label mb-2 block">Primary Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" value="#fa873e" class="w-10 h-10 rounded cursor-pointer border-0 p-0" />
                                <span class="text-sm font-mono text-gray-600">#FA873E</span>
                            </div>
                        </div>
                        <div>
                            <label class="p-label mb-2 block">Accent Color</label>
                            <div class="flex items-center gap-3">
                                <input type="color" value="#e06828" class="w-10 h-10 rounded cursor-pointer border-0 p-0" />
                                <span class="text-sm font-mono text-gray-600">#E06828</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t" style="border-color:rgba(250,135,62,.15)">
                    <div class="flex justify-end gap-4">
                        <button type="button" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg transition-colors uppercase text-sm tracking-wider">
                            Reset
                        </button>
                        <button type="button" class="p-btn px-8" onclick="alert('Settings saved successfully (Demo)')">
                            Save Configuration
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
