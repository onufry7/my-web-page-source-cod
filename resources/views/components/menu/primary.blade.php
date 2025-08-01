@use('Laravel\Jetstream\Jetstream')

<div class="container py-1 px-4 lg:px-8">
    <nav class="flex h-16 justify-between">

        <div class="flex gap-4">
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
                <a href="{{ route('home') }}">
                    <x-icon-application-logo class="block h-10 w-auto" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="my-2 hidden gap-4 sm:flex">

                <x-nav.link class="navs navs-main project" href="{{ route('project.index') }}" :active="request()->routeIs('project.*')">
                    {{ __('Projects') }} <x-rpg-mining-diamonds />
                </x-nav.link>

                <x-nav.link class="navs navs-main cipher" href="{{ route('cipher.index') }}" :active="request()->routeIs('cipher.*')">
                    {{ __('Ciphers') }} <x-rpg-rune-stone />
                </x-nav.link>

                <x-nav.link class="navs navs-main board-game" href="{{ route('board-game.index') }}" :active="request()->routeIs('board-game.*')">
                    {{ __('Board games') }} <x-rpg-pawn />
                </x-nav.link>

            </div>

        </div>

        <div class="m-2 flex items-center gap-4">

            <x-buttons.switch-theme-mode />

            <!-- Settings Dropdown -->
            <div class="hidden sm:block">
                <x-dropdown.dropdown align="right" width="48">
                    @auth
                        <x-slot name="trigger">
                            @if (Jetstream::managesProfilePhotos())
                                <button class="flex h-8 w-8 rounded-full border-2 border-transparent text-sm transition focus:border-indigo-300 focus:outline-none">
                                    <img class="rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button
                                    class="flex items-center rounded-md border border-transparent bg-white p-2 text-sm font-normal leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:bg-gray-50 focus:outline-none active:bg-gray-50 dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300 dark:focus:bg-gray-700 dark:active:bg-gray-700"
                                    type="button">
                                    {{ Auth::user()->name }}
                                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-nav.link class="navs navs-dropdown" href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                                {{ __('Profile') }} <x-icon-user class="h-6 w-auto" />
                            </x-nav.link>

                            <x-nav.link class="navs navs-dropdown" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }} <x-icon-dashboard class="h-6 w-auto" />
                            </x-nav.link>

                            @can('isAdmin')
                                <x-nav.link class="navs navs-dropdown" href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                    {{ __('Dashboard Admin') }} <x-icon-wolf class="h-6 w-auto" />
                                </x-nav.link>
                            @endcan

                            @if (Jetstream::hasApiFeatures())
                                <x-nav.link class="navs navs-dropdown" href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.*')">
                                    {{ __('API Tokens') }} <x-icon-compas class="h-6 w-auto" />
                                </x-nav.link>
                            @endif

                            <x-separators.custom-line class="bg-gray-500" />

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <x-nav.link class="navs navs-dropdown main-menu-logout" href="{{ route('logout') }}" x-on:click.prevent="$root.submit();">
                                    {{ __('Log Out') }} <x-icon-logout class="h-6 w-auto" />
                                </x-nav.link>
                            </form>
                        </x-slot>
                    @else
                        <!-- Login Register -->
                        <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button
                                    class="inline-flex items-center rounded-md border border-transparent p-2 text-sm font-normal leading-4 transition duration-150 ease-in-out text-indigo-500 hover:bg-gray-100 focus:bg-gray-100 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
                                    type="button">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                        </x-slot>

                        <x-slot name="content">
                            <x-nav.link class="navs navs-dropdown main-menu-login" href="{{ route('login') }}">
                                {{ __('Log in') }} <x-icon-login class="h-6 w-auto" />
                            </x-nav.link>
                        </x-slot>
                    @endauth
                </x-dropdown.dropdown>

            </div>

        </div>

        <!-- Hamburger -->
        <div class="-mr-2 flex items-center gap-6 sm:hidden">
            <button
                class="inline-flex items-center justify-center rounded-md p-2 transition duration-150 ease-in-out focus:outline-none text-indigo-500 hover:bg-gray-100 focus:bg-gray-100 dark:hover:bg-gray-800 dark:focus:bg-gray-800"
                x-on:click="open = ! open">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path class="inline-flex" :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                    <path class="hidden" :class="{ 'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </nav>
</div>
