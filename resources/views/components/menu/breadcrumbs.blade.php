@unless ($breadcrumbs->isEmpty())

    <nav class="container  py-2 px-4 sm:px-6 lg:px-8">
        <ol class="flex flex-wrap rounded px-4 text-sm list-inside">
            @foreach ($breadcrumbs as $breadcrumb)
                <li class="flex flex-wrap">
                    @if ($breadcrumb->url && !$loop->last)
                        <a class="link" href="{{ $breadcrumb->url }}">
                            <x-nav.breadcrumb-item :icon="$breadcrumb->icon ?? null" :title="$breadcrumb->title" />
                        </a>

                        <span class="px-2 text-gray-500">/</span>
                    @else
                        <span class="cursor-default">
                            <x-nav.breadcrumb-item :icon="$breadcrumb->icon ?? null" :title="$breadcrumb->title" />
                        </span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>

@endunless
