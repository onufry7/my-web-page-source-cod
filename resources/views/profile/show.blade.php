@use('Laravel\Fortify\Features')
@use('Laravel\Jetstream\Jetstream')

<x-app-layout>
    <x-slot name="header">
        {{ __('Profile') }}
    </x-slot>

    <div class="mx-auto max-w-7xl py-4 sm:px-6 lg:px-8">
        @if (Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')

            <x-sections.border />
        @endif

        @if (Features::enabled(Features::updatePasswords()))
            <div class="mt-10 sm:mt-0">
                @livewire('profile.update-password-form')
            </div>

            <x-sections.border />
        @endif

        @if (Features::canManageTwoFactorAuthentication())
            <div class="mt-10 sm:mt-0">
                @livewire('profile.two-factor-authentication-form')
            </div>

            <x-sections.border />
        @endif

        <div class="mt-10 sm:mt-0">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Jetstream::hasAccountDeletionFeatures())
            <x-sections.border />

            <div class="mt-10 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>

</x-app-layout>
