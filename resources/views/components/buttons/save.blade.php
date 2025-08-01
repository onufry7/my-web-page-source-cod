<button {{ $attributes->merge(['class' => 'btn primary']) }}>
    <x-icon-save /> {{ $slot }}
</button>
