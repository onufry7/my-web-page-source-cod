<button {{ $attributes->merge(['class' => 'btn danger']) }} title="{{ __('Delete') }}">
    <x-icon-trash /> {{ $slot }}
</button>
