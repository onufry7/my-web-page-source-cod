@props(['href' => null])

<{{ $href ? 'a' : 'button' }} @if ($href) href="{{ $href }}" @endif {{ $attributes->merge(['class' => 'btn secondary']) }} >
    <x-icon-cancel /> {{ $slot }}
</{{ $href ? 'a' : 'button' }}>
