@if (isset($icon))
    @svg($icon, ['class' => 'h-5 w-auto'])
@else
    {{ $title }}
@endif
