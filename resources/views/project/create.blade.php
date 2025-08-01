<x-app-layout>

    <x-slot name="header"> {{ __('Projects') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Add new project') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('project.store') }}" method="POST" :hasFiles=true x-data="{ selectedCategory: '{{ old('category', $project->category ?? '') }}' }">

        <x-slot name="form">
            @include('project.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('project.index') }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
