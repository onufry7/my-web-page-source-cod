<x-app-layout>

    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit file') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('file.update', $file) }}" method="PUT">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('File') }}: {{ $file->getNameWithModelName() }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('file.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('file.show', $file) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
