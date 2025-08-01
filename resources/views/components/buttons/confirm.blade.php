<button {{ $attributes->merge(['class' => 'btn success']) }}>
    <x-icon-confirm /> {{ $slot }}
</button>
