@props(['style' => session('flash.bannerStyle', 'success'), 'message' => session('flash.banner')])

<div class="container sm:rounded-md" style="display: none;" x-data="{{ json_encode(['show' => true, 'style' => $style, 'message' => $message]) }}"
    :class="{
        'bg-green-500 dark:bg-green-600': style == 'success',
        'bg-red-500 dark:bg-red-700': style == 'danger',
        'bg-yellow-400 dark:bg-yellow-600': style == 'warning'
    }"
    x-show="show && message" x-init="document.addEventListener('banner-message', event => {
        style = event.detail.style;
        message = event.detail.message;
        show = true;
    });">
    <div class="mx-auto px-2 py-2 sm:px-4 lg:px-6">
        <div class="flex flex-wrap items-center justify-between">
            <div class="flex w-0 min-w-0 flex-1 items-center">
                <span class="flex rounded-lg p-2" :class="{
                    'bg-green-600 dark:bg-green-700': style == 'success',
                    'bg-red-600 dark:bg-red-800': style == 'danger',
                    'bg-yellow-500 dark:bg-yellow-700': style == 'warning'
                }">
                    <svg class="h-5 w-5" x-show="style == 'success'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg class="h-5 w-5" x-show="style == 'danger'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                    <svg class="h-5 w-5" x-show="style == 'warning'" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2L2 20h20L12 2z" />
                        <line x1="12" y1="8" x2="12" y2="13" />
                        <circle cx="12" cy="17" r="0.5" fill="currentColor" />
                    </svg>

                </span>

                <p class="ml-4 truncate text-sm font-normal" x-text="message"></p>
            </div>

            <div class="shrink-0 sm:ml-4">
                <button class="-mr-1 flex rounded-md p-2 transition focus:outline-none sm:-mr-2" type="button" aria-label="Dismiss"
                    :class="{
                        'hover:bg-green-600 focus:bg-green-600 dark:hover:bg-green-700 dark:focus:bg-green-700': style == 'success',
                        'hover:bg-red-600 focus:bg-red-600 dark:hover:bg-red-800 dark:focus:bg-red-800': style == 'danger',
                        'hover:bg-yellow-500 focus:bg-yellow-500 dark:hover:bg-yellow-700 dark:focus:bg-yellow-700': style == 'warning',
                    }"
                    x-on:click="show = false">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
