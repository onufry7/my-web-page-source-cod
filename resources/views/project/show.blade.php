@section('title', ' - ' . $project->name)

<x-app-layout>

	<x-slot name="header">
		{{ __('Projects') }}
	</x-slot>


	<x-slot name="searchBar">
		@livewire('search-bars.project-search-bar')
	</x-slot>


    <x-slot name="imageBar">
        <x-image-bar :image="$project->image_path" noImage="images/project-no-image.webp"
            alt="{{ __('Project image') }}" class="rounded-lg border" />
    </x-slot>


    <x-slot name="pageHeader">
        <h2> <x-rpg-mining-diamonds /> {{ $project->name }} </h2>
    </x-slot>



	<div class="flex flex-col justify-center gap-8 md:gap-16 py-4">

		<div class="flex flex-col justify-between gap-8 prose dark:prose-invert mx-auto">
			<p> {{ $project->description }} </p>

			@if ($project->technologies->isNotEmpty())
				<div class="flex flex-row flex-wrap gap-2">
					<span class="font-bold">{{ __('Used technologies') }}:</span>
					<span class="flex flex-row flex-wrap gap-2 italic">
						{{ __(implode(', ', $project->technologies->pluck('name')->toArray())) }}.
					</span>
				</div>
			@endif
		</div>

        <x-sections.timestamps :model="$project" />

	</div>

	<section class="flex flex-row flex-wrap justify-center gap-8 px-2 pt-8 pb-4 md:gap-16">
		@if ($project->url)
			<a class="hover:animate-dring btn info" href="{{ $project->url }}" title="{{ __('Link to project') }}">
				<x-icon-link class="h-6 w-auto drop-shadow-sm" /> {{ __('Project') }}
			</a>
		@endif

		@if ($project->git)
			<a class="hover:animate-dring btn info" href="{{ $project->git }}" title="{{ __('Link to GitHub') }}">
				<x-icon-github class="h-6 w-auto drop-shadow-sm" /> {{ __('GitHub') }}
			</a>
		@endif
	</section>



	<x-sections.action-footer>

		<div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('project.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

		@can('isAdmin')
			<div class="flex flex-wrap justify-center gap-8">
				<x-buttons.edit href="{{ route('project.edit', $project) }}">
					{{ __('Edit') }}
				</x-buttons.edit>

				<x-forms.delete action="{{ route('project.destroy', $project) }}" content="{{ $project->name }}" />
			</div>
		@endcan

	</x-sections.action-footer>

</x-app-layout>
