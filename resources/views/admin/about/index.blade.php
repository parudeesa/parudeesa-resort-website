<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight p-serif">
            {{ __('About Us Manager') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="aboutManager()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Hero Section -->
            <div class="p-card p-6">
                <h3 class="p-serif text-lg font-bold text-[#e06828] mb-4 flex items-center">
                    <i data-lucide="image" class="w-5 h-5 mr-2"></i> Hero Banner
                </h3>
                <form action="{{ route('admin.about-us.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">Hero Title</label>
                            <input type="text" name="about_hero_title" value="{{ \App\Models\Setting::get('about_hero_title', 'About Our Paradise') }}" class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Hero Subtitle</label>
                            <input type="text" name="about_hero_subtitle" value="{{ \App\Models\Setting::get('about_hero_subtitle', 'Discover the story behind Parudeesa') }}" class="p-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="p-label">Hero Background Image</label>
                        <input type="file" name="about_hero_image" class="p-input">
                        @if(\App\Models\Setting::get('about_hero_image'))
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . \App\Models\Setting::get('about_hero_image')) }}" class="h-20 rounded-lg shadow-sm">
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="p-btn">Save Hero Settings</button>
                    </div>
                </form>
            </div>

            <!-- Brand Story Section -->
            <div class="p-card p-6">
                <h3 class="p-serif text-lg font-bold text-[#e06828] mb-4 flex items-center">
                    <i data-lucide="book-open" class="w-5 h-5 mr-2"></i> Brand Story
                </h3>
                <form action="{{ route('admin.about-us.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="form-group">
                        <label class="p-label">Story Title</label>
                        <input type="text" name="home_about_title" value="{{ \App\Models\Setting::get('home_about_title') }}" class="p-input">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">Story Paragraph 1</label>
                            <textarea name="home_about_desc_1" rows="4" class="p-input">{{ \App\Models\Setting::get('home_about_desc_1') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="p-label">Story Paragraph 2</label>
                            <textarea name="home_about_desc_2" rows="4" class="p-input">{{ \App\Models\Setting::get('home_about_desc_2') }}</textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">About Section Image</label>
                            <input type="file" name="home_about_image" class="p-input">
                            @if(\App\Models\Setting::get('home_about_image'))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . \App\Models\Setting::get('home_about_image')) }}" class="h-20 rounded-lg shadow-sm">
                                </div>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="form-group">
                                <label class="p-label">Badge Number</label>
                                <input type="text" name="home_about_badge_number" value="{{ \App\Models\Setting::get('home_about_badge_number') }}" class="p-input">
                            </div>
                            <div class="form-group">
                                <label class="p-label">Badge Text</label>
                                <input type="text" name="home_about_badge_text" value="{{ \App\Models\Setting::get('home_about_badge_text') }}" class="p-input">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="p-btn">Save Story Settings</button>
                    </div>
                </form>
            </div>

            <!-- Mission & Vision -->
            <div class="p-card p-6">
                <h3 class="p-serif text-lg font-bold text-[#e06828] mb-4 flex items-center">
                    <i data-lucide="target" class="w-5 h-5 mr-2"></i> Mission & Vision
                </h3>
                <form action="{{ route('admin.about-us.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">Our Mission</label>
                            <textarea name="about_mission" rows="4" class="p-input">{{ \App\Models\Setting::get('about_mission', 'To provide an unparalleled luxury experience that harmonizes with the natural beauty of Kerala.') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="p-label">Our Vision</label>
                            <textarea name="about_vision" rows="4" class="p-input">{{ \App\Models\Setting::get('about_vision', 'To be recognized globally as the ultimate sanctuary for peace, luxury, and authentic hospitality.') }}</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="p-btn">Save Mission/Vision</button>
                    </div>
                </form>
            </div>

            <!-- Values Section -->
            <div class="p-card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="p-serif text-lg font-bold text-[#e06828] flex items-center">
                        <i data-lucide="award" class="w-5 h-5 mr-2"></i> Our Values
                    </h3>
                    <button @click="openValueModal()" class="p-btn !py-2 !text-xs">+ Add Value</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="values-list">
                    @foreach($aboutValues as $value)
                        <div class="p-4 bg-white rounded-xl border border-orange-100 relative group" data-id="{{ $value->id }}">
                            <div class="flex justify-between items-start mb-2">
                                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center text-[#e06828]">
                                    <i data-lucide="{{ $value->icon ?? 'star' }}" class="w-5 h-5"></i>
                                </div>
                                <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="editValue({{ json_encode($value) }})" class="p-1 text-blue-500 hover:bg-blue-50 rounded"><i data-lucide="edit-2" class="w-4 h-4"></i></button>
                                    <form action="{{ route('admin.about-us.values.delete', $value->id) }}" method="POST" onsubmit="return confirm('Delete this value?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1 text-red-500 hover:bg-red-50 rounded"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                                    </form>
                                </div>
                            </div>
                            <h4 class="font-bold text-[#3e2010]">{{ $value->title }}</h4>
                            <p class="text-xs text-[#3e2010]/70 mt-1">{{ $value->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Meet the Team -->
            <div class="p-card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="p-serif text-lg font-bold text-[#e06828] flex items-center">
                        <i data-lucide="users" class="w-5 h-5 mr-2"></i> Meet the Team
                    </h3>
                    <button @click="openTeamModal()" class="p-btn !py-2 !text-xs">+ Add Member</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="team-list">
                    @foreach($teamMembers as $member)
                        <div class="p-4 bg-white rounded-xl border border-orange-100 relative group text-center" data-id="{{ $member->id }}">
                            <img src="{{ asset('storage/' . $member->image) }}" class="w-20 h-20 rounded-full mx-auto mb-3 object-cover border-2 border-orange-100">
                            <h4 class="font-bold text-[#3e2010] text-sm">{{ $member->name }}</h4>
                            <p class="text-[10px] uppercase tracking-widest text-[#e06828] font-bold">{{ $member->role }}</p>
                            
                            <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button @click="editTeam({{ json_encode($member) }})" class="p-1 text-blue-500 hover:bg-blue-50 rounded"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                <form action="{{ route('admin.about-us.team.delete', $member->id) }}" method="POST" onsubmit="return confirm('Delete member?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500 hover:bg-red-50 rounded"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Details Section -->
            <div class="p-card p-6">
                <h3 class="p-serif text-lg font-bold text-[#e06828] mb-4 flex items-center">
                    <i data-lucide="map-pin" class="w-5 h-5 mr-2"></i> Contact Details Section
                </h3>
                <form action="{{ route('admin.about-us.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">Contact Title</label>
                            <input type="text" name="about_contact_title" value="{{ \App\Models\Setting::get('about_contact_title', 'Get in Touch') }}" class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Contact Description</label>
                            <textarea name="about_contact_desc" rows="2" class="p-input">{{ \App\Models\Setting::get('about_contact_desc', 'Whether you have a question about booking, events, or our services, our team is ready to answer all your questions.') }}</textarea>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label class="p-label">Phone Number</label>
                            <input type="text" name="about_contact_phone" value="{{ \App\Models\Setting::get('about_contact_phone') }}" class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Email Address</label>
                            <input type="text" name="about_contact_email" value="{{ \App\Models\Setting::get('about_contact_email') }}" class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Location Address</label>
                            <input type="text" name="about_contact_address" value="{{ \App\Models\Setting::get('about_contact_address') }}" class="p-input">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="p-btn">Save Contact Settings</button>
                    </div>
                </form>
            </div>

            <!-- CTA Section -->
            <div class="p-card p-6">
                <h3 class="p-serif text-lg font-bold text-[#e06828] mb-4 flex items-center">
                    <i data-lucide="megaphone" class="w-5 h-5 mr-2"></i> CTA Section
                </h3>
                <form action="{{ route('admin.about-us.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="p-label">CTA Title</label>
                            <input type="text" name="about_cta_title" value="{{ \App\Models\Setting::get('about_cta_title', 'Ready to Experience Paradise?') }}" class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">CTA Description</label>
                            <input type="text" name="about_cta_desc" value="{{ \App\Models\Setting::get('about_cta_desc', 'Book your stay today and discover the magic of the backwaters.') }}" class="p-input">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="p-btn">Save CTA Settings</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Value Modal -->
        <div x-show="valueModal" class="fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl" @click.away="valueModal = false">
                <h3 class="p-serif text-xl font-bold text-[#e06828] mb-4" x-text="editingValue ? 'Edit Value' : 'Add New Value'"></h3>
                <form :action="editingValue ? `/admin/about-us/values/${editingValue.id}` : '{{ route('admin.about-us.values.store') }}'" method="POST">
                    @csrf
                    <template x-if="editingValue"><input type="hidden" name="_method" value="PATCH"></template>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="p-label">Title</label>
                            <input type="text" name="title" x-model="valueData.title" required class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Description</label>
                            <textarea name="description" x-model="valueData.description" required rows="3" class="p-input"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="p-label">Icon (Lucide name)</label>
                            <input type="text" name="icon" x-model="valueData.icon" placeholder="star, heart, leaf..." class="p-input">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="valueModal = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="p-btn" x-text="editingValue ? 'Update' : 'Add Value'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Team Modal -->
        <div x-show="teamModal" class="fixed inset-0 bg-black/50 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl" @click.away="teamModal = false">
                <h3 class="p-serif text-xl font-bold text-[#e06828] mb-4" x-text="editingTeam ? 'Edit Member' : 'Add Team Member'"></h3>
                <form :action="editingTeam ? `/admin/about-us/team/${editingTeam.id}` : '{{ route('admin.about-us.team.store') }}'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <template x-if="editingTeam"><input type="hidden" name="_method" value="PATCH"></template>
                    <div class="space-y-4">
                        <div class="form-group">
                            <label class="p-label">Name</label>
                            <input type="text" name="name" x-model="teamData.name" required class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Role</label>
                            <input type="text" name="role" x-model="teamData.role" required class="p-input">
                        </div>
                        <div class="form-group">
                            <label class="p-label">Photo</label>
                            <input type="file" name="image" :required="!editingTeam" class="p-input">
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 mt-6">
                        <button type="button" @click="teamModal = false" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                        <button type="submit" class="p-btn" x-text="editingTeam ? 'Update' : 'Add Member'"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function aboutManager() {
            return {
                valueModal: false,
                editingValue: null,
                valueData: { title: '', description: '', icon: 'star' },
                
                teamModal: false,
                editingTeam: null,
                teamData: { name: '', role: '' },

                init() {
                    this.initSortable('values-list', 'value');
                    this.initSortable('team-list', 'team');
                },

                initSortable(id, type) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    new Sortable(el, {
                        animation: 150,
                        ghostClass: 'opacity-50',
                        onEnd: (evt) => {
                            const order = Array.from(el.children).map(item => item.dataset.id);
                            this.updateOrder(type, order);
                        }
                    });
                },

                updateOrder(type, order) {
                    fetch('{{ route('admin.about-us.update_order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ type, order })
                    });
                },

                openValueModal() {
                    this.editingValue = null;
                    this.valueData = { title: '', description: '', icon: 'star' };
                    this.valueModal = true;
                },

                editValue(value) {
                    this.editingValue = value;
                    this.valueData = { ...value };
                    this.valueModal = true;
                },

                openTeamModal() {
                    this.editingTeam = null;
                    this.teamData = { name: '', role: '' };
                    this.teamModal = true;
                },

                editTeam(member) {
                    this.editingTeam = member;
                    this.teamData = { ...member };
                    this.teamModal = true;
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>
