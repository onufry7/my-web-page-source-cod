<x-app-layout>

    <x-slot name="header">
        {{ __('Shelf of shame') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-player-despair/> {{ __('List of games to play') }} <span>({{ $unplayedGames->count() }})</span> </h2>
    </x-slot>

    @if ($unplayedGames->isEmpty())
        <p class="mx-auto text-xl text-center p-4 mb-4 leading-10">{{ __("Congratulations on clearing your shelf of shame!") }} <br /> {{ __("Now it's time for new games and new emotions!") }}</p>
    @else
    <div class="flex flex-row flex-wrap my-8">
        @foreach ($unplayedGames as $game)
            <div class="px-4 pt-8 border-b-20 border-black grow dark:border-white flex justify-center items-end">
                <x-box-game-img :game="$game" />
            </div>
        @endforeach
    </div>
    @endif

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
