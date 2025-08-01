<x-app-layout>

    <x-slot name="header"> {{ __('Ciphers') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new cipher') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('cipher.store') }}" method="POST" :hasFiles=true>

        <x-slot name="form">
            @include('cipher.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('cipher.index') }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
