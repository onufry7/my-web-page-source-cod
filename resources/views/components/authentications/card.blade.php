<div class="flex min-h-screen flex-col items-center pt-6 sm:justify-center sm:pt-0">
    <div>
        <a href="{{ route('home') }}">
            <x-icon-application-logo class="h-24 w-auto" />
        </a>
    </div>

    <div class=" bg-slate-200/95 dark:bg-slate-900/95 mt-6 w-full overflow-hidden px-6 py-4 sm:max-w-xl sm:rounded-lg shadow-lg backdrop-blur-xl backdrop-filter">

        <div class="flex flex-row items-center justify-end mb-4 gap-8 border-b border-slate-300 dark:border-slate-700">
            @unless ($hideQuoteMarque ?? false)
                <x-aphorism-marquee />
            @endunless
            <x-buttons.switch-theme-mode />
        </div>

        <x-authentications.banner />

        {{ $slot }}
    </div>
</div>
