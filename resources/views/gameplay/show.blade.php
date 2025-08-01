<x-app-layout>

	<x-slot name="header">
		{{ __('Gameplays') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-rpg-slash-ring /> {{ __('Gameplay') }} </h2>
	</x-slot>

    <div class="flex flex-col gap-4 md:flex-row">

        @if ($gameplay->boardGame->box_img)
            <img class="max-h-48 max-w-48 object-contain m-4" src="{{ asset('storage/' . $gameplay->boardGame->box_img) }}" alt="{{ __('Box game') }}">
        @endif

        <div class="dataRow">
            <p>
                {{ __('Game name') }}:
                <a class="link" href="{{ route('board-game.show', $gameplay->boardGame) }}" title="{{ __('Show game') }}">
                    {{ $gameplay->boardGame->name }}
                </a>
            </p>

            <p>
                {{ __('Date') }}: <span>{{ $gameplay->date }}</span>
            </p>

            <p>
                {{ __('Number of gameplays') }}: <span>{{ $gameplay->count }}</span>
            </p>

            @can('isAdmin')
                <p>
                    {{ __('User name') }}: <span>{{ $gameplay->user->name }}</span>
                </p>
            @endcan
        </div>

    </div>

	<x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('gameplay.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

		<div class="flex flex-wrap justify-center gap-8">
			<x-buttons.edit href="{{ route('gameplay.edit', $gameplay) }}">
				{{ __('Edit') }}
			</x-buttons.edit>

			<x-forms.delete action="{{ route('gameplay.destroy', $gameplay) }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
