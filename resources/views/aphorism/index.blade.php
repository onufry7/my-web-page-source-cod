<x-app-layout>

    <x-slot name="header">
        {{ __('Aphorisms') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign/> {{ __('Aphorisms list') }} <span>({{ $aphorisms->total() }})</span> </h2>
        <x-buttons.create href="{{ route('aphorism.create') }}">
            {{ __('Add') }}
        </x-buttons.create>
    </x-slot>

    @if ($aphorisms->isEmpty())
        <x-no-data>{{ __('No aphorisms') }}.</x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('Aphorism') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aphorisms as $aphorism)
                        <tr>
                            <td>
                                <a class="block" href="{{ route('aphorism.show', $aphorism) }}" title="{{ __('Show') }}"> {{ $aphorism->sentence }} </a>
                            </td>
                            <td class="actions">
                                <span class="!flex-nowrap">
                                    <x-buttons.edit href="{{ route('aphorism.edit', $aphorism) }}" />
                                    <x-forms.delete id="delete-{{ $aphorism->id }}" :withTextDelete="false"
                                        action="{{ route('aphorism.destroy', $aphorism) }}"
                                        content="{{ __('Aphorism') }}: {{ $aphorism->sentence }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $aphorisms->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
