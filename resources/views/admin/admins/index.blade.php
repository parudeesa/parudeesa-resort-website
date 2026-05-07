<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Admin Management
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <i data-lucide="check-circle" class="w-5 h-5 mr-2"></i>
                <p class="font-bold mr-2">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm" role="alert">
            <div class="flex items-center">
                <i data-lucide="alert-circle" class="w-5 h-5 mr-2"></i>
                <p class="font-bold mr-2">Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Add Admin Form -->
            <div class="lg:col-span-1">
                <div class="p-card p-6 sm:p-8 h-full sticky top-8">
                    <h3 class="p-serif text-2xl font-bold mb-6 border-b pb-3 flex items-center" style="color:#3e2010; border-color:rgba(250,135,62,.15)">
                        <i data-lucide="user-plus" class="w-5 h-5 mr-2 text-[#e06828]"></i> Add New Admin
                    </h3>
                    <form action="{{ route('admin.admins.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="p-label">Full Name</label>
                            <input name="name" type="text" class="p-input mt-1" placeholder="John Doe" required minlength="3" maxlength="255" pattern="[A-Za-z\s]+" title="Name should only contain letters." />
                        </div>
                        <div>
                            <label class="p-label">Username</label>
                            <input name="username" type="text" class="p-input mt-1" placeholder="admin_john" required minlength="4" maxlength="255" pattern="[a-zA-Z0-9_-]+" title="Username can only contain letters, numbers, underscores and dashes." />
                        </div>
                        <div>
                            <label class="p-label">Email (Optional)</label>
                            <input name="email" type="email" class="p-input mt-1" placeholder="john@example.com" maxlength="255" />
                        </div>
                        <div>
                            <label class="p-label">Password</label>
                            <input name="password" type="password" class="p-input mt-1" placeholder="••••••••" required minlength="8" maxlength="255" />
                        </div>
                        <div class="pt-4 mt-2">
                            <button type="submit" class="p-btn w-full flex justify-center items-center">
                                <i data-lucide="save" class="w-4 h-4 mr-2"></i> Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Admin List Table -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <div class="p-card p-6 sm:p-8 flex-1">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b pb-3" style="border-color:rgba(250,135,62,.15)">
                        <h3 class="p-serif text-2xl font-bold flex items-center" style="color:#3e2010;">
                            <i data-lucide="users" class="w-5 h-5 mr-2 text-[#e06828]"></i> Registered Admins
                        </h3>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y" style="border-color:rgba(250,135,62,.15)">
                            <thead style="background:rgba(250,135,62,.05)">
                                <tr>
                                    <th class="px-6 py-4 text-left p-label rounded-tl-lg">Admin</th>
                                    <th class="px-6 py-4 text-left p-label">Role</th>
                                    <th class="px-6 py-4 text-left p-label">Status</th>
                                    <th class="px-6 py-4 text-left p-label">Joined</th>
                                    <th class="px-6 py-4 text-right p-label rounded-tr-lg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y bg-white/50" style="border-color:rgba(250,135,62,.15)">
                                @foreach($admins as $admin)
                                <tr class="hover:bg-orange-50/50 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-[#fa873e] to-[#e06828] flex items-center justify-center text-white font-bold mr-4">
                                                {{ substr($admin->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="p-serif text-lg font-bold p-text">{{ $admin->name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">@ {{ $admin->username }}</div>
                                                <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">{{ $admin->email ?: 'No Email' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600 uppercase">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $admin->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($admin->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $admin->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.admins.toggle_status', $admin->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="{{ $admin->status === 'active' ? 'bg-orange-100 text-[#e06828]' : 'bg-green-100 text-green-600' }} p-2 rounded-lg transition-colors" title="{{ $admin->status === 'active' ? 'Deactivate' : 'Activate' }}">
                                                    <i data-lucide="{{ $admin->status === 'active' ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                            
                                            <button onclick="document.querySelector('#edit-admin-{{ $admin->id }}').classList.toggle('hidden')" class="bg-blue-100 text-blue-600 p-2 rounded-lg transition-colors" title="Edit">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>

                                            <form action="{{ route('admin.admins.delete', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this admin account? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-50 text-red-600 p-2 rounded-lg transition-colors" title="Delete">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Form Row -->
                                <tr id="edit-admin-{{ $admin->id }}" class="hidden bg-orange-50/30">
                                    <td colspan="4" class="px-6 py-4">
                                        <div class="p-card p-6 bg-white border-2 border-orange-200">
                                            <h4 class="font-bold text-[#e06828] mb-4">Edit Admin: {{ $admin->name }}</h4>
                                            <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                @csrf
                                                @method('PATCH')
                                                <div>
                                                    <label class="p-label text-[10px]">Full Name</label>
                                                    <input name="name" type="text" value="{{ $admin->name }}" class="p-input mt-1" required minlength="3" maxlength="255" pattern="[A-Za-z\s]+" title="Name should only contain letters.">
                                                </div>
                                                <div>
                                                    <label class="p-label text-[10px]">Username</label>
                                                    <input name="username" type="text" value="{{ $admin->username }}" class="p-input mt-1" required minlength="4" maxlength="255" pattern="[a-zA-Z0-9_-]+" title="Username can only contain letters, numbers, underscores and dashes.">
                                                </div>
                                                <div>
                                                    <label class="p-label text-[10px]">Email</label>
                                                    <input name="email" type="email" value="{{ $admin->email }}" class="p-input mt-1" maxlength="255">
                                                </div>
                                                <div>
                                                    <label class="p-label text-[10px]">New Password (leave blank to keep current)</label>
                                                    <input name="password" type="password" class="p-input mt-1" placeholder="••••••••" minlength="8" maxlength="255">
                                                </div>
                                                <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                                                    <button type="button" onclick="document.querySelector('#edit-admin-{{ $admin->id }}').classList.add('hidden')" class="px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                                                    <button type="submit" class="p-btn px-6">Update Admin</button>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
