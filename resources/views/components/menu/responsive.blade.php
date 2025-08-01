@use('Laravel\Jetstream\Jetstream')

<nav class="hidden sm:hidden" :class="{ 'block': open, 'hidden': !open }">

    <!-- Responsive Main Menu -->
    <div class="space-y-1 border-t border-gray-200 pb-3 pt-2 dark:border-gray-600">
        <x-nav.link class="navs navs-responsive project" href="{{ route('project.index') }}" :active="request()->routeIs('project.*')">
            {{ __('Projects') }} <x-rpg-mining-diamonds class="h-6 w-auto" />
        </x-navs.link>

        <x-nav.link class="navs navs-responsive cipher" href="{{ route('cipher.index') }}" :active="request()->routeIs('cipher.*')">
            {{ __('Ciphers') }} <x-rpg-rune-stone class="h-6 w-auto" />
        </x-navs.link>

        <x-nav.link class="navs navs-responsive board-game" href="{{ route('board-game.index') }}" :active="request()->routeIs('board-game.*')">
            {{ __('Board games') }} <x-rpg-pawn class="h-6 w-auto" />
        </x-navs.link>
    </div>

    <!-- Responsive Settings Options -->
    <div class="border-t border-gray-200 pb-1 pt-4 dark:border-gray-600">
        @auth
            <div class="flex items-center px-4">
                @if (Jetstream::managesProfilePhotos())
                    <div class="mr-3 shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif
                <div>
                    <div class="text-base font-normal text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-normal text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-nav.link class="navs navs-responsive" href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }} <x-icon-user class="h-6 w-auto" />
                </x-navs.link>

                <x-nav.link class="navs navs-responsive" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }} <x-icon-dashboard class="h-6 w-auto" />
                </x-navs.link>

                @can('isAdmin')
                    <x-nav.link class="navs navs-responsive" href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard Admin') }} <x-icon-wolf class="h-6 w-auto" />
                    </x-navs.link>
                @endcan

                @if (Jetstream::hasApiFeatures())
                    <x-nav.link class="navs navs-responsive" href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.*')">
                        {{ __('API Tokens') }} <x-icon-compas class="h-6 w-auto" />
                    </x-navs.link>
                @endif

                <!-- Authentication -->
                <form class="border-t border-gray-200 dark:border-gray-600" method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <x-nav.link class="navs navs-responsive main-menu-logout" href="{{ route('logout') }}" x-on:click.prevent="$root.submit();">
                        {{ __('Log Out') }} <x-icon-logout class="h-6 w-auto" />
                    </x-navs.link>
                </form>
            </div>
        @else
            <!-- Login Register -->
            <div class="space-y-1">
                <x-nav.link class="navs navs-responsive main-menu-login" href="{{ route('login') }}">
                    {{ __('Log in') }} <x-icon-login class="h-6 w-auto" />
                </x-navs.link>
            </div>
        @endauth
    </div>
</nav>
