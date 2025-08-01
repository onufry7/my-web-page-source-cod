<x-app-layout>

    <x-slot name="header">
        {{ __('Aphorisms') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit aphorism') }} </h2>
    </x-slot>

    <x-forms.classic method="PUT" action="{{ route('aphorism.update', $aphorism) }}">

        <x-slot name="form">
            @include('aphorism.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('aphorism.show', $aphorism) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
