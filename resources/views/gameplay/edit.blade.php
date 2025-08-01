<x-app-layout>

	<x-slot name="header">
		{{ __('Gameplays') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2>
			<x-icon-pencil /> {{ __('Edit gameplay') }}
		</h2>
	</x-slot>

	<x-forms.classic method="PUT" action="{{ route('gameplay.update', $gameplay) }}">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Gameplay') }}: {{ $gameplay->boardGame->name }}</h3>
        </x-slot>

		<x-slot name="form">
			@include('gameplay.form-fields')
		</x-slot>

		<x-slot name="actions">
            <x-buttons.cancel href="{{ route('gameplay.show', $gameplay) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
		</x-slot>
	</x-forms.classic>

</x-app-layout>
