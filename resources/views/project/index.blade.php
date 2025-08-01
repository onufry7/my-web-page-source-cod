<x-app-layout>

    <x-slot name="header">
        {{ __('Projects') }}
    </x-slot>

    <x-slot name="searchBar">
        @livewire('search-bars.project-search-bar')
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __('Projects list') }} <span>({{ $projects->total() }})</span>
        </h2>

        @can('isAdmin')
            <x-buttons.create href="{{ route('project.create') }}">
                {{ __('Add') }}
            </x-buttons.create>
        @endcan
    </x-slot>

    {{-- <x-slot name="infoBar">
        @include('project.menu')
    </x-slot> --}}

    <div class="box-container">
        @each('project.project-box', $projects, 'project', 'project.list-empty')
    </div>

    <div class="pagination-links">
        {{ $projects->withQueryString()->links() }}
    </div>

</x-app-layout>
