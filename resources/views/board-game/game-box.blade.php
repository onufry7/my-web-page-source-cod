<article class="box-tile border-accent-board-game shadow-accent-board-game">

    <div>
        <a class="block" href="{{ route('board-game.show', $game) }}">
            <div class="box-tile-img border-accent-board-game">
                <div class="pin-btn bg-white dark:bg-black absolute bottom-0 right-0 z-10 overflow-hidden p-1">
                    <x-board-game.type-icon data-type="{{ $game->type }}" class="size-6" />
                </div>
                <x-image-bar :image="$game->box_img" noImage="images/board-game-no-image.webp" alt="{{ __('Game cover') }}" imgClass="image-bar-responsive" />
            </div>

            <h3 class="border-accent-board-game">
                {{ Str::title($game->name) }}
            </h3>
        </a>

        <p class="line-clamp-3 px-6 py-2 overflow-hidden">
            {{ $game->description }}
        </p>
    </div>


    <footer>
        <a href="{{ route('board-game.show', $game) }}">
            {{ __('More') }} >>
        </a>
    </footer>

</article>
