@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white dark:bg-gray-700', 'dropdownClasses' => ''])

@php
    switch ($align) {
        case 'left':
            $alignmentClasses = 'origin-top-left left-0';
            break;
        case 'top':
            $alignmentClasses = 'origin-top';
            break;
        case 'none':
        case 'false':
            $alignmentClasses = '';
            break;
        case 'center':
            $alignmentClasses = 'left-1/2 transform -translate-x-1/2';
            break;
        case 'right':
        default:
            $alignmentClasses = 'origin-top-right right-0';
            break;
    }

    switch ($width) {
        case '48':
            $width = 'w-48';
            break;
        case 'auto':
            $width = 'w-auto';
            break;
    }
@endphp

<div class="relative" x-data="{ open: false }" x-on:click.away="open = false" x-on:close.stop="open = false" >
    <div x-on:click="open = ! open">
        {{ $trigger }}
    </div>

    <div class="{{ $width }} {{ $alignmentClasses }} {{ $dropdownClasses }} absolute z-50 mt-2 rounded-md shadow-lg" style="display: none;" x-show="open"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" x-on:click="open = false">
        <div class="{{ $contentClasses }} rounded-md ring-1 ring-black ring-opacity-5">
            {{ $content }}
        </div>
    </div>
</div>
