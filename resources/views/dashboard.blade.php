<x-app-layout>

    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    <x-slot name="pageHeader">
        <h2 class="w-full justify-center"> {{ __('Welcome') }} {{ auth()->user()->nick ? auth()->user()->nick : auth()->user()->name }}!</h2>
    </x-slot>

    <nav class="my-8 w-full flex flex-row flex-wrap justify-around gap-8">
        <a class="tile-btn" href="{{ route('gameplay.index') }}">
            <x-rpg-slash-ring class="h-10 w-auto" />
            <span class="text-center">
                {{ __('Gameplays') }}
                <br>
                {{ $gameplaysCount }}
            </span>
        </a>

        <a class="tile-btn" href="{{ route('shelf.shame') }}">
            <x-rpg-player-despair class="h-10 w-auto" />
            <span class="text-center">
                {{ __('Shelf of shame') }}
                <br>
                {{ $unplayedGamesCount }}
            </span>
        </a>
    </nav>

    <div class="my-2 flex flex-col gap-8 py-4">
        {{-- Top 10 --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Top 10 - Your most frequently played games') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col"> {{ __('Position') }} </th>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Game name') }} <x-icon-eye />
                            </span>
                            </th>
                        <th scope="col" class="text-center hidden sm:table-cell"> {{ __('Number of gameplays') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($top10Games as $gameplays)
                        <tr>
                            <th scope="row">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                            </th>
                            <td>
                                <a class="block" href="{{ route('board-game.show', $gameplays->boardGame) }}">
                                    {{ $gameplays->boardGame->name }}
                                </a>
                            </td>
                            <td class="text-center hidden sm:table-cell"> {{ $gameplays->total_count }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Gameplays in the last 10 years --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('Gameplays in the last 10 years') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col"> {{ __('Year') }} </th>
                        <th scope="col" class="text-center"> {{ __('Number of gameplays') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gameplaysCountByYear as $gameplay)
                        <tr>
                            <td> {{ $gameplay->year }} </td>
                            <td class="text-center"> {{ $gameplay->total_count }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Popular game of the year --}}
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <caption class="caption-bottom p-4 text-xs">
                    {{ __('The most popular game of the year') }}.
                </caption>
                <thead>
                    <tr>
                        <th scope="col"> {{ __('Year') }} </th>
                        <th scope="col"> {{ __('Game name') }} </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mostPopularGameByYear as $game)
                        <tr>
                            <td> {{ $game->year }} </td>
                            <td> {{ $game->name }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
