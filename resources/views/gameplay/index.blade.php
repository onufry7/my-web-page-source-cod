<x-app-layout>
	<x-slot name="header">
		{{ __('Gameplays') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-rpg-wooden-sign /> {{ __('Gameplays list') }} <span>({{ $gameplaysCount }})</span> </h2>

		<x-buttons.create href="{{ route('gameplay.create') }}">
			{{ __('Add') }}
		</x-buttons.create>
	</x-slot>

	@if ($gameplays->isEmpty())
        <x-no-data> {{ __('No gameplays') }}. </x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Game name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="text-center" scope="col">
                            {{ __('Date') }}
                        </th>
                        <th class="text-center hidden sm:table-cell" scope="col">
                            {{ __('Number of gameplays') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gameplays as $gameplay)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('gameplay.show', $gameplay) }}" title="{{ __('Show gameplay data') }}">
                                    {{ $gameplay->boardGame->name }}
                                </a>
                            </th>
                            <td class="text-center">{{ $gameplay->date }}</td>
                            <td class="text-center hidden sm:table-cell">{{ $gameplay->count }}</td>
                            <td class="actions">
                                <span>
                                    <x-buttons.edit href="{{ route('gameplay.edit', $gameplay) }}" />
                                    <x-forms.delete id="delete-{{ $gameplay->id }}" :withTextDelete="false"
                                    content="{{ $gameplay->name }}" action="{{ route('gameplay.destroy', $gameplay) }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

	<div class="pagination-links">
		{{ $gameplays->withQueryString()->links() }}
	</div>

	<x-sections.action-footer>
        <x-buttons.backward href="{{ route('dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
	</x-sections.action-footer>

</x-app-layout>
