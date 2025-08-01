<x-app-layout>

    <x-slot name="header">
        {{ __('Board games') }}
    </x-slot>

    <x-slot name="imageBar">
        <x-image-bar :image="$boardGame->box_img" noImage="images/board-game-no-image.webp"
            alt="{{ __('Board game image') }}" class="rounded-lg border" />
    </x-slot>

    <x-slot name="pageHeader">
        <h2>
            <x-rpg-wooden-sign /> {{ __('Files') }}: {{ $boardGame->name }}
        </h2>

        @can('isAdmin')
            <x-buttons.create href="{{ route('board-game.add-file', ['boardGame' => $boardGame]) }}">
                {{ __('Add') }}
            </x-buttons.create>
        @endcan
    </x-slot>

    @if ($boardGame->files->count() > 0)
        <div class="relative my-2 overflow-x-auto shadow-md sm:rounded-lg">
            <table class="default-table">
                <thead>
                    <tr>
                        <th scope="col">
                            <span class="show-icon">
                                {{ __('File name') }} <x-icon-eye />
                            </span>
                        </th>
                        <th class="actions" scope="col">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($boardGame->files as $key => $file)
                        <tr>
                            <th scope="row">
                                <a class="block" href="{{ route('file.show', $file) }}" title="{{ __('Show') }}">
                                        {{ $file->name }}
                                </a>
                            </th>
                            <td class="actions">
                                <span>
                                    <x-buttons.download href="{{ route('file.download', $file) }}" />
                                    <x-buttons.edit href="{{ route('file.edit', $file) }}" />
                                    <x-forms.delete id="{{ $file->id }}" :withTextDelete="false" content="{{ __('File') }}: {{ $file->name }}"
                                        action="{{ route('file.destroy', $file) }}" />
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <x-no-data> {{ __('No files') }}. </x-no-data>
    @endif

    <x-sections.action-footer>
        <x-buttons.backward href="{{ route('board-game.show', $boardGame) }}">
            {{ __('To board game') }}
        </x-buttons.backward>
    </x-sections.action-footer>

</x-app-layout>
