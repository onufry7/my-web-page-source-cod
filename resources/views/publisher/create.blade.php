<x-app-layout>

    <x-slot name="header">
        {{ __('Publishers') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new publisher') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('publisher.store') }}">

        <x-slot name="form">
            @include('publisher.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.backward href="{{ route('publisher.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>
    </x-forms.classic>

</x-app-layout>
