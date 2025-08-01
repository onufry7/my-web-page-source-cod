@php
$players = $boardGame->getPlayersNumber();
$altMin = $boardGame->getAltMinPlayersFromExpansion();
$altMax = $boardGame->getAltMaxPlayersFromExpansion();
@endphp

<div class="flex flex-row flex-wrap gap-x-8 gap-y-4 px-4 py-2 mt-2 rounded-md justify-evenly bg-green-300 dark:bg-green-700">

    <span class="flex flex-row flex-wrap items-center gap-1">
        <x-board-game.type-icon data-type="{{ $boardGame->type }}" class="size-8" />
        {{ __($boardGameType::from($boardGame->type)->name) }}
    </span>

    @if (!empty($boardGame->age))
        <span class="flex flex-row flex-wrap items-center gap-1">
            <x-rpg-player-lift class="size-8" />
            {{ $boardGame->age }}+
        </span>
    @endif

    @if ($players || $altMin || $altMax)
        <span class="flex flex-row flex-wrap items-center gap-1">
            <x-rpg-double-team class="size-8" />
                {{ $altMin ? "($altMin)" : '' }}
                <b>{{ $players }}</b>
                {{ $altMax ? "($altMax)" : '' }}
        </span>
    @endif

    @if (!empty($boardGame->game_time))
        <span class="flex flex-row flex-wrap items-center gap-1">
            <x-rpg-hourglass class="size-8" />
            {{ $boardGame->game_time }} min.
        </span>
    @endif

</div>
