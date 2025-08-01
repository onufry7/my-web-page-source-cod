<x-app-layout>

    <x-slot name="header">
        {{ __('Technologies') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new technology') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('technology.store') }}">
        <x-slot name="form">
            @include('technology.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('technology.index') }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>
    </x-forms.classic>

</x-app-layout>
