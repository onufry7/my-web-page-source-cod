<x-app-layout>

    <x-slot name="header">
        {{ __('Sleeves') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new sleeves') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('sleeve.store') }}" :hasFiles=true>
        <x-slot name="form">
            @include('sleeve.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.backward href="{{ route('sleeve.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>
    </x-forms.classic>

</x-app-layout>
