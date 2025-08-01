@props(['id' => null, 'maxWidth' => null])

<x-popups.modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class= "px-6 py-4">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>

            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                <h3 class="text-lg font-normal">
                    {{ $title }}
                </h3>

                <div class="text-muted mt-4 text-sm">
                    {{ $content ?? ''}}
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 flex flex-row justify-between gap-8">
        {{ $footer }}
    </div>
</x-popups.modal>
