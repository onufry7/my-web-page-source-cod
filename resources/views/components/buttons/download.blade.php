<a {{ $attributes->merge(['class' => 'btn success']) }} title="{{ $title ?? __('Download') }}">
    <x-icon-arrow-down-tray /> {{ $slot }}
</a>
