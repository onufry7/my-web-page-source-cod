<div class="flex justify-between md:col-span-1">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-normal">{{ $title }}</h3>

        <p class="text-muted mt-1 text-sm">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
