<x-app-layout>

    <x-slot name="header">
        {{ __('Admin Dashboard') }}
    </x-slot>

    <nav class="my-8 flex flex-row flex-wrap justify-center gap-8">

        <a class="tile-btn" href="{{ route('access-token.index') }}">
            <x-icon-finger-print class="h-10 w-auto" />
            <span>{{ __('Access tokens') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('user.index') }}">
            <x-icon-community class="h-10 w-auto" />
            <span>{{ __('Users') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('technology.index') }}">
            <x-icon-cpu class="h-10 w-auto" />
            <span>{{ __('Technologies') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('publisher.index') }}">
            <x-icon-rocked class="h-10 w-auto" />
            <span>{{ __('Publishers') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('sleeve.index') }}">
            <x-rpg-fire-shield class="h-10 w-auto" />
            <span>{{ __('Sleeves') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('aphorism.index') }}">
            <x-rpg-lantern-flame class="h-10 w-auto" />
            <span>{{ __('Aphorisms') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('admin.statistics.index') }}">
            <x-icon-stats-report class="h-10 w-auto" />
            <span>{{ __('Statistics') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('file.index') }}">
            <x-icon-multiple-pages class="h-10 w-auto" />
            <span>{{ __('Files') }}</span>
        </a>

        <a class="tile-btn" href="{{ route('print.index') }}">
            <x-icon-printer class="h-10 w-auto" />
            <span>{{ __('Prints') }}</span>
        </a>

    </nav>

</x-app-layout>
