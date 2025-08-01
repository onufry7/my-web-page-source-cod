<x-app-layout>

    <x-slot name="header">
        {{ __('Sleeves') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit sleeves') }} </h2>
    </x-slot>

    <x-forms.classic method="PUT" action="{{ route('sleeve.update', $sleeve) }}" :hasFiles=true>

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Sleeve') }}: {{ $sleeve->getFullName() }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('sleeve.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('sleeve.show', $sleeve) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
