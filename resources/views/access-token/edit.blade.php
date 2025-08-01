<x-app-layout>

    <x-slot name="header"> {{ __('Access tokens') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil/> {{ __('Edit token access') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('access-token.update', $accessToken) }}" method="PUT">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Access token') }}: {{ $accessToken->token }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('access-token.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('access-token.show', $accessToken) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
