@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-sections.title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-sections.title>

    <div class="mt-4 md:col-span-2 md:mt-0 rounded-lg border-l border-gray-600">
        <form wire:submit="{{ $submit }}">
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex flex-col-reverse sm:flex-row gap-8 p-4 sm:px-6">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
