<x-app-layout>

    <x-slot name="header">
        {{ __('Board games') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __($title) }}
            @if($countPlayers != 0) {{ $countPlayers }} @endif
        </h2>
    </x-slot>


    <div class="my-2 overflow-x-auto shadow-md sm:rounded-lg">
        @if ($games->isEmpty())
            @include('board-game.list-empty')
        @else
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Game name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th scope="col"> {{ __('Type') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($games as $game)
                        <tr>
                            <td>
                                <a class="block" href="{{ route('board-game.show', $game->slug) }}" title="{{ __('Show') }}">
                                    {{ Str::title($game->name) }}
                                </a>
                            </td>
                            <td>
                                {{ __($game->getNameType()) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination-links">
                {{ $games->withQueryString()->links() }}
            </div>
        @endif
    </div>


    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center gap-8">
            <x-buttons.backward href="{{ route('board-game.index') }}">
                {{ __('To boardgames') }}
            </x-buttons.backward>

            @can('isAdmin')
                <x-buttons.backward href="{{ route('admin.statistics.index') }}">
                    {{ __('To statistics') }}
                </x-buttons.backward>
            @endcan
        </div>
    </x-sections.action-footer>

</x-app-layout>
