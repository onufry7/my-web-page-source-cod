<x-app-layout>

    <x-slot name="header"> {{ __('Access tokens') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus/> {{ __('Add new access token') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('access-token.store') }}" method="POST">

        <x-slot name="form">
            @include('access-token.form-fields')
        </x-slot>

        {{-- Actions --}}
        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('access-token.index') }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
