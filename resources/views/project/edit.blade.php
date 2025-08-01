<x-app-layout>

    <x-slot name="header"> {{ __('Projects') }} </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-pencil /> {{ __('Edit project') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('project.update', $project) }}" method="PUT" :hasFiles=true x-data="{ selectedCategory: '{{ old('category', $project->category ?? '') }}' }">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Project') }}: {{ $project->name }}</h3>
        </x-slot>

        <x-slot name="form">
            @include('project.form-fields')
        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('project.show', $project) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
