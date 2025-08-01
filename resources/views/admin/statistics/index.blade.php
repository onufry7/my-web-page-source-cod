<x-app-layout>

    <x-slot name="header">
        {{ __('Statistics') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign /> {{ __('Basic statistics') }} </h2>
    </x-slot>


    <h3 class="text-center sm:text-left">{{ __('Data in numbers') }}:</h3>
    <div class="my-2 flex flex-row flex-wrap justify-center gap-4">
        @foreach ($countModels as $model)
            <div class="statistics-tile">
                <a class="block " href="{{ route(Str::slug(Str::singular($model['name'])) . '.index') }}" title="{{ __('Show') }}"> {{ __($model['name']) }} </a>
                <span>{{ $model['count'] }}</span>
            </div>
        @endforeach
    </div>

    <hr class="my-4 border-gray-500" />

    <h3 class="text-center sm:text-left">{{ __('Board games') }}:</h3>

    <div class="my-2 flex flex-row flex-wrap justify-center gap-4">

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.index') }}" title="{{ __('Show') }}"> {{ __('Base game count') }} </a>
            <span>{{ $boardGame->get('baseCount') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.index', ['type' => 'dodatki']) }}" title="{{ __('Show') }}"> {{ __('Expansion count') }} </a>
            <span>{{ $boardGame->get('expansionCount') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.index', ['type' => 'wszystkie']) }}" title="{{ __('Show') }}"> {{ __('Game count') }} </a>
            <span>{{ $boardGame->get('totalGameCount') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'bez-instrukcji']) }}" title="{{ __('Show') }}"> {{ __('Without instructions') }} </a>
            <span>{{ $boardGame->get('withoutInstructionCount') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'bez-insertu']) }}" title="{{ __('Show') }}"> {{ __('Needed insert') }} </a>
            <span>{{ $boardGame->get('neededInsertCount') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'do-koszulkowania']) }}" title="{{ __('Show') }}"> {{ __('Sleeve up') }} </a>
            <span>{{ $boardGame->get('toSleeved') }}</span>
        </div>

        <div class="statistics-tile">
            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'do-malowania']) }}" title="{{ __('Show') }}"> {{ __('To painting') }} </a>
            <span>{{ $boardGame->get('toPainting') }}</span>
        </div>
    </div>

    <hr class="my-4 border-gray-500" />

    <div class="my-2 flex flex-col gap-8">

        {{-- Top 10 --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Top 10 - most frequently played games') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col"> {{ __('Position') }} </th>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Game name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center hidden sm:table-cell" scope="col"> {{ __('Gameplay count') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topTenGames as $gameplays)
                        <tr>
                            <th class="w-10" scope="row">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                            </th>
                            <td>
                                <a class="block" href="{{ route('board-game.show', $gameplays->boardGame) }}" title="{{ __('Show') }}">
                                    {{ Str::title($gameplays->boardGame->name) }}
                                </a>
                            </td>
                            <td class="text-center hidden sm:table-cell">
                                {{ $gameplays->sum_count }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Played / To Played --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Number of play games and to play games') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Played') }} <x-icon-eye />
                            </span>
                        </th>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('To play') }} <x-icon-eye />
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'zagrane']) }}" title="{{ __('Show played') }}">
                                {{ $playedToNotPlayed->get('played') }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a class="block" href="{{ route('board-game.specific-list', ['type' => 'niezagrane']) }}" title="{{ __('Show to played') }}">
                                {{ $playedToNotPlayed->get('noPlayed') }}
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Game on Count players --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Number of games for each number of players') }}.
                </caption>
                <thead>
                    <tr>
                        <th class="text-center" scope="col"> {{ __('Number of games') }} </th>
                        <th class="text-center" scope="col"> {{ __('Number of players') }} </th>
                        <th class="actions" scope="col"> {{ __('Actions') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countGamesForPlayers as $key => $countGames)
                        <tr>
                            <td class="text-center">{{ $countGames }}</td>
                            <td class="text-center">{{ $key }}</td>
                            <td class="actions">
                                <span>
                                    <x-buttons.show href="{{ route('board-game.specific-list', ['type' => 'liczba-graczy', 'countPlayers' => $key]) }}" title="{{ __('Show') }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Publishers --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Percentage share of publishers in collection') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Publisher') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center hidden sm:table-cell" scope="col"> {{ __('Games count in collection') }} </th>
                        <th class="text-center" scope="col"> {{ __('Collection percentage') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishersInCollect as $publisherName => $publisher)
                        <tr>
                            <th scope="row">
                                @if(is_null($publisher['model']))
                                    <a class="block" href="{{ route('board-game.specific-list', ['type' => 'bez-wydawcy']) }}" title="{{ __('Show') }}"> {{ __($publisherName) }} </a>
                                @else
                                    <a class="block" href="{{ route('publisher.show', $publisher['model']) }}" title="{{ __('Show') }}"> {{ $publisherName }} </a>
                                @endif
                            </th>
                            <td class="text-center hidden sm:table-cell">
                                {{ $publisher['games_count'] }}
                            </td>
                            <td class="text-center">
                                {{ $publisher['percent'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Percentage share of publishers in collection - only base game') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Publisher') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center hidden sm:table-cell" scope="col"> {{ __('Games count in collection') }} </th>
                        <th class="text-center" scope="col"> {{ __('Collection percentage') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishersInCollectBaseGame as $publisherName => $publisher)
                        <tr class="border-b bg-gray-100 hover:bg-gray-200 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                            <th class="px-4 py-2 font-medium text-gray-900 dark:text-white" scope="row">
                                @if(is_null($publisher['model']))
                                    <a class="block" href="{{ route('board-game.specific-list', ['type' => 'podstawowe-bez-wydawcy']) }}" title="{{ __('Show') }}"> {{ __($publisherName) }} </a>
                                @else
                                    <a class="block" href="{{ route('publisher.show', $publisher['model']) }}" title="{{ __('Show') }}"> {{ $publisherName }} </a>
                                @endif
                            </th>
                            <td class="text-center hidden sm:table-cell">
                                {{ $publisher['games_count'] }}
                            </td>
                            <td class="text-center">
                                {{ $publisher['percent'] }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>



    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('admin.dashboard') }}">
                {{ __('To Dashboard') }}
            </x-buttons.backward>
        </div>
    </x-sections.action-footer>

</x-app-layout>
