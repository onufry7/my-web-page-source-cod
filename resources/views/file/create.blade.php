<x-app-layout>

    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new file') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('file.store') }}" method="POST" :hasFiles=true>

        @if (isset($model) && $model->name)
            <x-slot name="title">
                <h3 class="ml-4 mb-8">{{ __('Add file') }} {{ __('to: :model', ['model' => $model->name]) }}</h3>
            </x-slot>
        @endif


        <x-slot name="form">
            @include('file.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.backward href="{{ route('file.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
