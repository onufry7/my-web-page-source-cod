<x-app-layout>

	<x-slot name="header">
		{{ __('Sleeves') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-rpg-wooden-sign /> {{ __('Sleeves list') }} <span>({{ $sleeves->total() }})</span> </h2>
		<x-buttons.create href="{{ route('sleeve.create') }}">
			{{ __('Add') }}
		</x-buttons.create>
	</x-slot>

	@if ($sleeves->isEmpty())
        <x-no-data> {{ __('No sleeves') }}. </x-no-data>
	@else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table my-16">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Sleeves') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center" scope="col">
                            {{ __('Cover') }}
                        </th>
                        <th class="text-center" scope="col">
                            {{ __('Size') }}
                        </th>
                        <th class="text-center" scope="col">
                            {{ __('Availability') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sleeves as $key => $sleeve)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('sleeve.show', $sleeve) }}" title="{{ __('Show') }}">
                                    {{ Str::title($sleeve->getFullName()) }}
                                </a>
                            </th>
                            <td class="flex justify-center items-center">
                                <x-image-or-placeholder :imagePath="$sleeve->image_path" alt="cover" class="w-12 min-h-12" :zoom=true />
                            </td>
                            <td class="text-center">
                                {{ $sleeve->getSize() }}
                            </td>
                            <td class="text-center">
                                {{ $sleeve->getQuantityAvailable() }}
                            </td>
                            <td class="actions">
                                <span>
                                    <a class="btn accent" href="{{ route('sleeve.stock', $sleeve) }}" title="{{ __('Stock') }}"> <x-rpg-gold-bar /> </a>
                                    <x-buttons.edit href="{{ route('sleeve.edit', $sleeve) }}" />
                                    <x-forms.delete id="delete-{{ $sleeve->id }}" :withTextDelete="false"
                                        action="{{ route('sleeve.destroy', $sleeve) }}" content="{{ __('Sleeves') }}: {{ $sleeve->getFullName() }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $sleeves->withQueryString()->links() }}
    </div>

	<x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
	</x-sections.action-footer>

</x-app-layout>
