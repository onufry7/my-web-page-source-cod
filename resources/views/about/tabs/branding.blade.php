<h3 class="py-4 text-center">{{ __('Professionally') }}</h3>

<ul class="space-y-8">

	<li>
		<span class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center">
			<x-icon-map class="h-8 w-auto" /> <b>{{ __('Working region') }}:</b> <span>{{ __('Remote work') }}, Kraków, Małopolska</span>
		</span>
	</li>

	<li>
		<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary" href="https://www.linkedin.com/in/szymon-burnejko" title="{{ __('My profile on LinkedIn') }}">
			<x-icon-linkedin class="h-8 w-auto" /> www.linkedin.com/in/szymon-burnejko
		</a>
	</li>

	<li>
		<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary" href="https://github.com/onufry7" title="{{ __('My GitHub') }}">
			<x-icon-github class="h-8 w-auto" /> github.com/onufry7
		</a>
	</li>

	@if (file_exists(public_path('storage/documents/cv/burnejko-cv.pdf')))
		<li>
			<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary" href="{{ route('cv.download') }}" title="{{ __('My CV') }}">
				<x-icon-arrow-down-tray class="h-8 w-auto" /> {{ __('Download CV') }}
			</a>
		</li>
	@endif

</ul>

@can('isAdmin')
    <x-separators.hr-accent-color class="mt-4" />
	<div class="buttons-panel justify-center">
		<x-buttons.edit class="m-auto" href="{{ route('cv.form') }}" title="Zaktualizuj plik CV">
			{{ __('Update CV') }}
		</x-buttons.edit>
	</div>
@endcan
