<x-app-layout>

	<x-slot name="header">
		{{ __('Publishers') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-icon-rocked/> {{ $publisher->name }} </h2>
	</x-slot>

	<div class="dataRow">
		<p>
			{{ __('Publisher name') }}: <span>{{ $publisher->name }}</span>
		</p>
		@if ($publisher->website)
			<p class="flex flex-row flex-wrap items-center gap-2">
				{{ __('Publisher website') }}:
                <a class="link" href="{{ $publisher->website }}" title="{{ __('To publisher website') }}">
                    {{ $publisher->website }}
                </a>
			</p>
		@endif
	</div>

	@if ($publisher->getBoardGames()->isNotEmpty())
        <x-separators.hr />

		<section class="flex flex-col gap-y-2 px-2 py-4">
			<h3>{{ __('Publishing games') }}:</h3>
			<div class="flex flex-row flex-wrap justify-evenly items-end gap-4 px-4 py-2">
				@foreach ($publisher->getBoardGames() as $boardGame)
					<x-box-game-img :game="$boardGame" />
				@endforeach
			</div>
		</section>
	@endif

	<x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('publisher.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

		<div class="flex flex-wrap justify-center gap-8">
			<x-buttons.edit href="{{ route('publisher.edit', $publisher) }}">
				{{ __('Edit') }}
			</x-buttons.edit>
			<x-forms.delete action="{{ route('publisher.destroy', $publisher->id) }}" content="{{ __('Publisher') }}: {{ $publisher->name }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
