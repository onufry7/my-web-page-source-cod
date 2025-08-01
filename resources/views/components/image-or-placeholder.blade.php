@props(['imagePath', 'alt' => '', 'class' => '', 'zoom' => false])


<div class="relative inline-block group object-cover">
    @if (isset($imagePath) && file_exists(public_path('storage/' . $imagePath)))
        <img class="{{ $class }}" src="{{ asset('storage/' . $imagePath) }}" alt="{{ $alt }}" />
        @if($zoom)
            <div class="absolute top-1/2 left-1/2 w-32 h-auto z-30 opacity-0 scale-90 pointer-events-none group-hover:opacity-100 group-hover:scale-100 group-hover:pointer-events-auto transition-all duration-300 ease-in-out transform -translate-x-1/2 -translate-y-1/2">
                <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $alt }}" class="w-full h-full object-cover" />
            </div>
        @endif
    @else
        <div class="{{ $class }} bg-black/10 dark:bg-white/10"></div>
    @endif
</div>
