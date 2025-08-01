<x-app-layout>

    <x-slot name="header">
        {{ __('Files') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign /> {{ __('Files list') }} <span>({{ $files->total() }})</span> </h2>
    </x-slot>

    @if ($files->isEmpty())
        <x-no-data> {{ __('No files') }}. </x-no-data>
    @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('File name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th scope="col">
                            {{ __('Size') }}
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $key => $file)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('file.show', $file) }}" title="{{ __('Show') }}"> {{ $file->getNameWithModelName() }} </a>
                            </th>
                            <td>
                                {{ $file->getSize(inMB: true) }}
                            </td>
                            <td class="actions">
                                <span>
                                    <x-buttons.download href="{{ route('file.download', $file) }}" />
                                    <x-buttons.edit href="{{ route('file.edit', $file) }}" />
                                    <x-forms.delete id="delete-{{ $file->id }}" :withTextDelete="false"
                                        content="{{ __('File') }}: {{ $file->name }}" action="{{ route('file.destroy', $file) }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="pagination-links">
        {{ $files->withQueryString()->links() }}
    </div>

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('admin.dashboard') }}">
            {{ __('To Dashboard') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
