<x-app-layout>

    <x-slot name="header">
        {{ __('Ciphers') }}
    </x-slot>

    <x-slot name="searchBar">
        @livewire('search-bars.cipher-search-bar')
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __('Ciphers list') }} <span>({{ $ciphers->total() }})</span>
        </h2>

        @can('isAdmin')
            <x-buttons.create href="{{ route('cipher.create') }}">
                {{ __('Add') }}
            </x-buttons.create>
        @endcan
    </x-slot>

    <x-slot name="infoBar">
        @include('cipher.menu')
    </x-slot>

    <div class="box-container">
        @each('cipher.cipher-box', $ciphers, 'cipher', 'cipher.list-empty')
    </div>

    <div class="pagination-links">
        {{ $ciphers->withQueryString()->links() }}
    </div>

</x-app-layout>
