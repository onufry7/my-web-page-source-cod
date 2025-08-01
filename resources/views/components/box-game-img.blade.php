@props(['game'])

<div class="flex flex-col items-center text-center">
    <a
        href="{{ route('board-game.show', $game) }}"
        class="group relative max-w-fit"
        data-tooltip-target="tooltip-default-{{ $game->id }}"
    >
        <span class="absolute inset-0 flex items-center justify-center p-2 text-sm w-full h-full text-gray-900 dark:text-gray-100 bg-white dark:bg-black opacity-0 transition-opacity group-hover:opacity-75 rounded-sm">
            {{ $game->name }}
        </span>

        @if ($game->box_img && file_exists(public_path('storage/' . $game->box_img)))
            <img
                src="{{ asset('storage/' . $game->box_img) }}"
                alt="{{ $game->name }}"
                class="max-h-36 max-w-36 object-contain shadow-lg rounded-sm"
            >
        @else
            <span class="flex items-center justify-center p-2 text-sm h-36 w-36 object-contain border border-black bg-gray-300 dark:bg-gray-600 shadow-lg rounded-sm">
                {{ $game->name }}
            </span>
        @endif
    </a>
</div>

