<x-app-layout>

    <x-slot name="header"> {{ __('Board games') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit boardgame') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('board-game.update', $boardGame) }}" method="PUT" :hasFiles=true x-data="{ selectedType: '{{ old('type', $boardGame->type ?? '') }}' }">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Game') }}: {{ $boardGame->name }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('board-game.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('board-game.show', $boardGame) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
