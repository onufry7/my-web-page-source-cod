<div class="relative w-full mt-8" x-data="{ open: true }" x-on:click.outside="open = false">

    {{-- Search input --}}
    <div class="relative">
        <input type="search" id="nazwa" name="nazwa" autocomplete="off" placeholder="{{ __('Search by name') }}..."
            required x-on:click="open = true" wire:model.live.debounce.500ms="search"
            wire:loading.class='rounded-b-none' class="input-no-cancel block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900
                dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2
                focus:ring-indigo-500 focus:border-indigo-500 rounded-lg pr-20 py-2 px-2 transition-shadow duration-150
                @if($dynamicSearch) rounded-b-none @endif" />
        {{-- przycisk "x" i lupa --}}
        <div class="flex flex-row justify-center items-center gap-1 absolute right-0 top-1/2 -translate-y-1/2">
            <button type="button" x-show="$wire.search" x-on:click="$wire.set('search', '');"
                aria-label="{{ __('Clean search') }}" class="p-1">
                <x-icon-cancel class="size-4 dark:text-white text-black" />
            </button>
            <span class="text-xl border-l border-indigo-600 px-2">&#x1F50E;</span>
        </div>
    </div>

    {{-- Dropdown container --}}
    <div
        class="absolute z-50 w-full rounded-b-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 @if($dynamicSearch) border-t-2 border-indigo-600 @endif ">

        {{-- Loading state --}}
        <div x-show="open" x-cloak wire:loading class="w-full">
            <div class="mx-auto w-full rounded-b-lg border border-indigo-600 px-4 py-2 text-center text-sm font-medium">
                <span class="animate-pulse">{{ __('Searching') }}...</span>
            </div>
        </div>


        {{-- Search results --}}
        @if ($dynamicSearch)
            <div x-show="open" x-cloak wire:loading.remove
                class="max-h-96 overflow-y-auto rounded-b-lg border border-indigo-600">
                @forelse ($records as $record)
                    <a href="{{ route($model . '.show', $record->slug) }}"
                        class="block border-b border-indigo-600 px-4 py-2 text-sm last:border-0 hover:bg-gray-100 dark:hover:bg-gray-800">
                        {{ $record->name }}
                    </a>
                @empty
                    <div class="w-full px-4 py-2 text-center text-sm">
                        {{ __('No results') }}.
                    </div>
                @endforelse
            </div>
        @endif

    </div>
</div>
