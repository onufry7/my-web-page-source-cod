<x-app-layout>

    <x-slot name="header">
        {{ __('Technologies') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit technology') }} </h2>
    </x-slot>

    <x-forms.classic method="PUT" action="{{ route('technology.update', $technology) }}">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Technology') }}: {{ $technology->name }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('technology.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('technology.show', $technology) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
