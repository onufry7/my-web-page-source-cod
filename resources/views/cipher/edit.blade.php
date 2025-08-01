<x-app-layout>

    <x-slot name="header">
        {{ __('Ciphers') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit cipher') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('cipher.update', $cipher) }}" method="PUT" :hasFiles=true>

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Cipher') }}: {{ $cipher->name }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('cipher.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('cipher.show', $cipher) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
