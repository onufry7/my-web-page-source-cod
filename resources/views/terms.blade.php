<x-guest-layout>
    <div class="bg-gray-100 pt-4 dark:bg-gray-900">
        <div class="flex min-h-screen flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-icon-application-logo class="size-24" />
            </div>

            <div class="prose mx-auto mt-6 w-full overflow-hidden bg-white p-6 shadow-md dark:prose-invert dark:bg-gray-800 sm:max-w-2xl sm:rounded-lg">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
