@props(['id' => null, 'maxWidth' => null])

<x-popups.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-normal">
            {{ $title }}
        </div>

        <div class="text-muted mt-4 text-sm">
            {{ $content }}
        </div>
    </div>

    <div class="px-6 py-4 flex flex-row justify-between gap-8">
        {{ $footer }}
    </div>
</x-popups.modal>
