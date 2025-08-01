<x-app-layout>

    <x-slot name="header">
        {{ __('Technologies') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign/> {{ __('Technologies list') }} <span>({{ $technologies->total() }})</span> </h2>
        <x-buttons.create href="{{ route('technology.create') }}">
            {{ __('Add') }}
        </x-buttons.create>
    </x-slot>

    @if ($technologies->isEmpty())
        <x-no-data>{{ __('No technologies') }}.</x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Technology') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($technologies as $key => $technology)
                        <tr>
                            <td>
                                <a class="block" href="{{ route('technology.show', $technology) }}" title="{{ __('Show') }}"> {{ $technology->name }} </a>
                            </td>
                            <td class="actions">
                                <span>
                                    <x-buttons.edit href="{{ route('technology.edit', $technology) }}" />
                                    <x-forms.delete id="delete-{{ $technology->id }}" :withTextDelete="false"
                                        action="{{ route('technology.destroy', $technology) }}"
                                        content="{{ __('Technology') }}: {{ $technology->name }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $technologies->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
