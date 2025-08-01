<x-app-layout>

    <x-slot name="header">
        {{ __('Prints') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-wooden-sign /> {{ __('Prints list') }} </h2>
    </x-slot>

    <ul class="flex flex-col gap-4 px-4 list-none">
        @forelse ($prints as $print)
            <li class="flex items-center gap-2">
                <span class="shrink-0">📜</span>
                <a class="link ml-2" href="{{ route('print.board-game-pdf', ['id' => $print['id']]) }}" title="{{ __('Download print') }}.">
                    {{ __($print['title']) }}
                </a>
            </li>
        @empty
            <li> {{ __('No prints') }} </li>
        @endforelse
    </ul>


    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('admin.dashboard') }}">
                {{ __('To Dashboard') }}
            </x-buttons.backward>
        </div>
    </x-sections.action-footer>

</x-app-layout>
