<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-sections.title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-sections.title>

    <div class="mt-4 md:col-span-2 md:mt-0">
        <div class="rounded-lg border-l border-gray-600 p-4 sm:p-6">
            {{ $content }}
        </div>
    </div>
</div>
