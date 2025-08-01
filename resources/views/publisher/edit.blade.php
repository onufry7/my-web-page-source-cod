<x-app-layout>

    <x-slot name="header">
        {{ __('Publishers') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit publisher') }} </h2>
    </x-slot>

    <x-forms.classic method="PUT" action="{{ route('publisher.update', $publisher) }}">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Publisher') }}: {{ $publisher->name }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('publisher.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('publisher.show', $publisher) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>
    </x-forms.classic>

</x-app-layout>
