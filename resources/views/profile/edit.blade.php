<x-admin-layout>
    <x-slot name="header">
        <h2 class="p-serif font-semibold text-2xl" style="color:#e06828;">
            Profile Settings
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-7xl mx-auto pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-card p-6 sm:p-8">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-card p-6 sm:p-8">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-card p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-admin-layout>
