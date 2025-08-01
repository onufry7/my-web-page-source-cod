@props(['image', 'noImage', 'alt', 'imgClass' => 'image-bar', 'class' => ''])


<div class="overflow-hidden border-{{ $accentColor }} {{ $class }}">

    @if (isset($image) && file_exists(public_path('storage/' . $image)))
        <img class="{{ $imgClass }}" src="{{ asset('storage/' . $image) }}" alt="{{ $alt }}" />
    @else
        <img class="{{ $imgClass }}" src="{{ asset($noImage) }}" alt="{{ __('No graphic') }}" />
    @endif

</div>
