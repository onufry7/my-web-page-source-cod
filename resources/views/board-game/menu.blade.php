<section class="simple-menu">
    <ul class="border-accent-board-game list-inside">
        <li class="border-accent-board-game">
            <a class=" @if(is_null($type)) active @endif" href="{{ route('board-game.index') }}">
                <x-rpg-round-bottom-flask class="size-8" /> {{ __('Base') }}
            </a>
        </li>
        <li class="border-accent-board-game">
            <a class=" @if($type === 'dodatki') active @endif" href="{{ route('board-game.index', ['type' => 'dodatki']) }}">
                <x-rpg-vial class="size-8" /> {{ __('Expansion') }}
            </a>
        </li>
        <li class="border-accent-board-game">
            <a class=" @if($type === 'wszystkie') active @endif" href="{{ route('board-game.index', ['type' => 'wszystkie']) }}">
                <x-rpg-bottle-vapors class="size-8" /> {{ __('All') }}
            </a>
        </li>
    </ul>
</section>
