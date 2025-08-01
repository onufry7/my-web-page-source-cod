<x-app-layout>

	<x-slot name="header">
		{{ __('Technologies') }}
	</x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-cpu /> {{ $technology->name }} </h2>
    </x-slot>

	<div class="dataRow">
		<p>
		    {{ __('Technology name') }}: <span>{{ $technology->name }}</span>
		</p>
	</div>

	<x-sections.action-footer>
		<div class="flex flex-wrap justify-center">
			<x-buttons.backward href="{{ route('technology.index') }}">
                {{ __('To list') }}
			</x-buttons.backward>
		</div>

		<div class="flex flex-wrap justify-center gap-8">
			<x-buttons.edit href="{{ route('technology.edit', $technology) }}">
				{{ __('Edit') }}
			</x-buttons.edit>
			<x-forms.delete action="{{ route('technology.destroy', $technology) }}" content="{{ __('Technology') }}: {{ $technology->name }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
