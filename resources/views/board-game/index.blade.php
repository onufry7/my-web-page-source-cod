<x-app-layout>

    <x-slot name="header">
        {{ __('Board games') }}
    </x-slot>

    <x-slot name="searchBar">
        @livewire('search-bars.board-game-search-bar', ['type' => $type])
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __('Board games list') }} <span>({{ $games->total() }})</span>
        </h2>

        @can('isAdmin')
            <x-buttons.create href="{{ route('board-game.create') }}">
                {{ __('Add') }}
            </x-buttons.create>
        @endcan
    </x-slot>

    <x-slot name="infoBar">
        @include('board-game.menu')
    </x-slot>

    <div class="box-container">
        @each('board-game.game-box', $games, 'game', 'board-game.list-empty')
    </div>

    <div class="pagination-links">
        {{ $games->withQueryString()->links() }}
    </div>

</x-app-layout>
