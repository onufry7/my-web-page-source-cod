<x-app-layout>

	<x-slot name="header">
		{{ __('Board games') }}
	</x-slot>

    <x-slot name="imageBar">
        <x-image-bar :image="$boardGame->box_img" noImage="images/board-game-no-image.webp" alt="{{ __('Board game image') }}" class="rounded-lg border" />
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __('Sleeves') }}: {{ $boardGame->name }}
        </h2>

        @can('isAdmin')
            <x-buttons.create href="{{ route('board-game-sleeve.create', ['boardGame' => $boardGame]) }}">
                {{ __('Add') }}
            </x-buttons.create>
        @endcan
    </x-slot>


    @if ($boardGame->sleeves->isEmpty())
        <x-no-data> {{ __('No sleeves') }}. </x-no-data>
    @else
        <div class="box-container">
            @foreach ($boardGame->sleeves as $key => $sleeve)

                <div class="sleeve-card">

                    <a href="{{ route('sleeve.show', $sleeve) }}" class="group block p-0">
                        <header class="backdrop-blur-sm text-center p-2 rounded-t-lg">
                            {{ $sleeve->mark }} <br> {{ $sleeve->name }}
                        </header>

                        <x-separators.custom-line class="separator" />

                        <div class="h-60 w-full">
                            @if ($sleeve->image_path)
                                <img src="{{ asset('storage/' . $sleeve->image_path) }}" alt="{{ $sleeve->mark }}"
                                    class="h-full w-full object-cover object-top" />
                            @endif
                        </div>

                        <div class="backdrop-blur-sm text-center p-2">
                            {{ $sleeve->getSize() }} <br>
                            {{ $sleeve->pivot->quantity }} szt.
                        </div>

                        <x-separators.custom-line class="separator" />
                    </a>

                    {{-- Przyciski --}}
                    <footer class="flex flex-wrap justify-evenly gap-4 p-2 rounded-b-lg">
                        @if ($sleeve->pivot->sleeved)
                            <a class="btn danger" href="{{ route('board-game-sleeve.turn-off', [$boardGame, $sleeve->pivot]) }}" title="{{ __('Take off') }}">
                                <x-icon-shield-minus />
                            </a>
                        @else
                            <a class="btn success" href="{{ route('board-game-sleeve.put', [$boardGame, $sleeve->pivot]) }}" title="{{ __('Put on') }}">
                                <x-icon-shield-plus />
                            </a>

                            <x-forms.delete id="delete-{{ $sleeve->pivot->id }}" :withTextDelete="false" content="{{ __('Sleeves') }}: {{ $sleeve->getFullName() }}"
                                action="{{ route('board-game-sleeve.destroy', [$boardGame, 'boardGameSleeveId' => $sleeve->pivot->id]) }}" />
                        @endif
                    </footer>
                </div>

            @endforeach
        </div>
    @endif

	<x-sections.action-footer>
        <x-buttons.backward href="{{ route('board-game.show', $boardGame) }}">
            {{ __('To board game') }}
        </x-buttons.backward>
	</x-sections.action-footer>

</x-app-layout>
