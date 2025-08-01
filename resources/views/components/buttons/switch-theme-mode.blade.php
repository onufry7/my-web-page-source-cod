<x-dropdown.dropdown align="center" width="auto">
    <x-slot name="trigger">
        <button class="flex items-center justify-center overflow-hidden rounded-full}" title="{{ __('Motyw') }}">
            <x-icon-sun class="block h-8 stroke-blue-500 hover:stroke-sky-500 dark:hidden" />
            <x-icon-moon class="hidden h-8 stroke-blue-500 hover:stroke-sky-500 dark:block" />
        </button>
    </x-slot>

    <x-slot name="content">
        <div class="block px-4 py-2 text-xs text-gray-400">
            {{ __('Theme') }}
        </div>
        <div class="border-t border-gray-200 dark:border-gray-600"></div>
        <ul class="text-gray-700 dark:text-gray-300 list-inside">
            <li class="flex items-center gap-2 px-2 py-2 sm:py-1" id="darkMode">
                <x-icon-moon class="h-6 w-6" />
                {{ __('Dark') }}
            </li>
            <li class="flex items-center gap-2 px-2 py-2 sm:py-1" id="lightMode">
                <x-icon-sun class="h-6 w-6" />
                {{ __('Light') }}
            </li>
            <li class="flex items-center gap-2 px-2 py-2 sm:py-1" id="systemMode">
                <x-icon-system class="h-6 w-6" />
                {{ __('System') }}
            </li>
        </ul>
    </x-slot>
</x-dropdown.dropdown>
