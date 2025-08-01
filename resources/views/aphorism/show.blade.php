<x-app-layout>

	<x-slot name="header">
		{{ __('Aphorisms') }}
	</x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-lantern-flame /> {{ __('Aphorism') }} </h2>
    </x-slot>

	<div class="dataRow">
		<blockquote>
            <p class="mx-auto">{{ __('Sentence') }}:</p>
            <p class="py-4 px-8 mx-auto">{{ $aphorism->sentence }}</p>
            @if ($aphorism->author)
                <footer class="prose dark:prose-invert text-right mx-auto">— <cite>{{ $aphorism->author }}</cite></footer>
            @endif
        </blockquote>
	</div>

	<x-sections.action-footer>
		<div class="flex flex-wrap justify-center">
			<x-buttons.backward href="{{ route('aphorism.index') }}">
                {{ __('To list') }}
			</x-buttons.backward>
		</div>

		<div class="flex flex-wrap justify-center gap-8">
			<x-buttons.edit href="{{ route('aphorism.edit', $aphorism) }}">
				{{ __('Edit') }}
			</x-buttons.edit>
			<x-forms.delete action="{{ route('aphorism.destroy', $aphorism) }}" content="{{ __('Aphorism') }}: {{ $aphorism->sentence }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
