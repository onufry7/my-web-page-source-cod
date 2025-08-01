@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" role="navigation" aria-label="{{ __('Pagination Navigation') }}">

        <div class="flex flex-1 justify-between gap-4 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex cursor-default items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium leading-5 text-gray-300">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                    href="{{ $paginator->previousPageUrl() }}">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                    href="{{ $paginator->nextPageUrl() }}">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="relative ml-3 inline-flex cursor-default items-center rounded-md border border-gray-300 bg-gray-100 px-4 py-2 text-sm font-medium leading-5 text-gray-300">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex sm:flex-col sm:justify-center items-center">

            <div class="select-none">
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex cursor-default items-center rounded-l-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium leading-5 text-gray-300"
                            aria-disabled="true" aria-label="{{ __('pagination.previous') }}" aria-hidden="true">
                            <x-icon-nav-arrow-left class="size-5" />
                        </span>
                    @else
                        <a class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
                            href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('pagination.previous') }}" rel="prev">
                            <x-icon-nav-arrow-left class="size-5" />
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span
                                class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700"
                                aria-disabled="true">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-sky-100 px-4 py-2 text-sm font-medium leading-5 text-gray-500"
                                        aria-current="page">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
                                        href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
                            href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" rel="next">
                            <x-icon-nav-arrow-right class="size-5" />
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="relative -ml-px inline-flex cursor-default items-center rounded-r-md border border-gray-300 bg-gray-100 px-2 py-2 text-sm font-medium leading-5 text-gray-300"
                                aria-hidden="true">
                                <x-icon-nav-arrow-right class="size-5" />
                            </span>
                        </span>
                    @endif
                </span>
            </div>

            <div>
                <p class="my-2 text-center text-xs leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

        </div>

    </nav>
@endif
