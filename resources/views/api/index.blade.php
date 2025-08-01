<x-app-layout>
    <x-slot name="header">
        {{ __('API Tokens') }}
    </x-slot>

    <div>
        <div class="bg-theme-second mx-auto max-w-7xl overflow-hidden px-4 py-10 shadow-xl sm:rounded-lg sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-app-layout>
