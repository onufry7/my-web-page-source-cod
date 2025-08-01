<x-app-layout>

    <x-slot name="header">
        {{ __('Publishers') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign/> {{ __('Publishers list') }} <span>({{ $publishers->total() }})</span> </h2>

        <x-buttons.create href="{{ route('publisher.create') }}">
            {{ __('Add') }}
        </x-buttons.create>
    </x-slot>

    @if ($publishers->isEmpty())
        <x-no-data> {{ __('No publishers') }}. </x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Publisher') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="hidden sm:table-cell" scope="col">
                            {{ __('Publisher website') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($publishers as $key => $publisher)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('publisher.show', $publisher) }}" title="{{ __('Show') }}"> {{ $publisher->name }} </a>
                            </th>
                            <td class="hidden sm:table-cell">
                                <a class="link" href="{{ $publisher->website }}" title="{{ __('To publisher website') }}"> {{ $publisher->website }} </a>
                            </td>
                            <td class="actions">
                                <span>
                                    <x-buttons.edit href="{{ route('publisher.edit', $publisher) }}" />
                                    <x-forms.delete id="delete-{{ $publisher->id }}" :withTextDelete="false"
                                        action="{{ route('publisher.destroy', $publisher) }}" content="{{ __('Publisher') }}: {{ $publisher->name }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $publishers->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
