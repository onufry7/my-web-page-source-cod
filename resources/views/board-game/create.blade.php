<x-app-layout>

    <x-slot name="header"> {{ __('Board games') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new board game') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('board-game.store') }}" method="POST" :hasFiles=true x-data="{ selectedType: '{{ old('type', $boardGame->type ?? '' )}}' }">

        <x-slot name="form">
            @include('board-game.form-fields')
        </x-slot>

        {{-- Actions --}}
        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('board-game.index') }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
