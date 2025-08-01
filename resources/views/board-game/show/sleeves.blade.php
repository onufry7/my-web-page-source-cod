@foreach ($boardGame->sleeves as $key => $sleeve)
    <div class="sleeve-card-mini">
        <div class="size-40 rounded-t-lg">
            @if ($sleeve->image_path)
                <img src="{{ asset('storage/' . $sleeve->image_path) }}" alt="{{ $sleeve->mark }}"
                    class="h-full w-full object-cover object-top" />
            @endif
        </div>
        <div class="backdrop-blur-sm text-center text-sm p-2 rounded-b-lg">
            {{ $sleeve->getSize() }} <br>
            {{ $sleeve->pivot->quantity }} szt.
        </div>
    </div>
@endforeach
