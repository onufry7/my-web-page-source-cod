@props(['action', 'content', 'id', 'maxWidth', 'withTextDelete' => true])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth ?? '2xl'];
@endphp

<div x-data="{ 'showModal': false }" x-on:keydown.escape="showModal = false" {{ $attributes->merge(['class']) }}>
    <form id="{{ $id ?? 'delete' }}" action="{{ $action }}" method="POST">
        @method('DELETE') @csrf
    </form>

    <x-buttons.delete type="button" x-on:click="showModal = true">
            {{ $withTextDelete ? __('Delete') : '' }}
    </x-buttons.delete>


    <div
        class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto px-4 py-6 sm:px-0 bg-white/75 dark:bg-black/75"
        x-show="showModal"
        x-on:close.stop="showModal = false"
        x-on:keydown.escape.window="showModal = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0" x-on:click="showModal = false"></div>

        <div
            class="body-text-color body-bg {{ $maxWidth }} my-6 transform overflow-hidden rounded-2xl shadow-xl transition-all sm:mx-auto sm:w-full z-60 relative"
            x-trap.inert.noscroll="showModal"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="px-6 py-4">
                <div class="text-lg font-normal">
                    {{ __('Are you sure you want to delete this record?') }}
                </div>

                @if (isset($content) && !empty($content))
                    <div class="text-muted mt-4 text-sm">
                        {{ $content }}
                    </div>
                @endif
            </div>

            <x-separators.hr />

            <footer class="px-6 py-4 flex flex-row flex-wrap items-center justify-center sm:justify-between gap-8">
                <button class="btn light" x-on:click="showModal = false">
                    <x-icon-cancel /> {{ __('Cancel') }}
                </button>
                <button class="btn danger" form="{{ $id ?? 'delete' }}">
                    <x-icon-trash /> {{ __('Delete') }}
                </button>
            </footer>
        </div>
    </div>

</div>
