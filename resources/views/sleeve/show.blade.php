<x-app-layout>

	<x-slot name="header">
		{{ __('Sleeves') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-rpg-fire-shield /> {{ $sleeve->getFullName() }} </h2>
	</x-slot>

    <div class="flex flex-col gap-4 md:flex-row">

        @if ($sleeve->image_path)
            <img class="max-h-48 max-w-48 object-contain m-4" src="{{ asset('storage/' . $sleeve->image_path) }}" alt="{{ __('Sleeves cover') }}">
        @endif

        <div class="dataRow">
            <p> {{ __('Sleeves name') }}: <span>{{ Str::title($sleeve->name) }}</span> </p>

            <p> {{ __('Sleeves mark') }}: <span>{{ Str::title($sleeve->mark) }}</span> </p>

            <p>
                {{ __('Sleeves size') }}:
                <span>{{ $sleeve->width }} <span class="text-sm">x</span> {{ $sleeve->height }}&nbsp;mm </span>
            </p>

            @if($sleeve->thickness)
                <p> {{ __('Sleeves thickness') }}: <span>{{ $sleeve->thickness }}&nbsp;&micro;m</span> </p>
            @endif

            <p> {{ __('Quantity available') }}: <span>{{ $sleeve->getQuantityAvailable() }}</span> </p>

            <x-sections.timestamps :model="$sleeve" />
        </div>
    </div>

    @if ($corrects->isNotEmpty())
        <x-separators.hr-accent-color />
        @include('sleeve.show.corrects', ['corrects' => $corrects])
    @endif

    @if ($games->isNotEmpty())
        <x-separators.hr-accent-color />
        @include('sleeve.show.games', ['games' => $games])
    @endif

	<x-sections.action-footer>
		<div class="flex flex-wrap justify-center">
			<x-buttons.backward href="{{ route('sleeve.index') }}">
                {{ __('To list') }}
			</x-buttons.backward>
		</div>

		<div class="flex flex-wrap justify-center gap-8">
			<a class="btn accent" href="{{ route('sleeve.stock', $sleeve) }}" title="{{ __('Stock') }}">
                <x-rpg-gold-bar /> {{ __('Stock') }}
            </a>

            <x-buttons.edit href="{{ route('sleeve.edit', $sleeve) }}">
                {{ __('Edit') }}
            </x-buttons.edit>

            <x-forms.delete action="{{ route('sleeve.destroy', $sleeve) }}"
                content="{{ __('Sleeves') }}: {{ $sleeve->getFullName() }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
