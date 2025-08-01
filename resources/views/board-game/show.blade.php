@section('title', ' - ' . $boardGame->name)

<x-app-layout>

	<x-slot name="header">
		{{ __('Board games') }}
	</x-slot>


	<x-slot name="searchBar">
		@livewire('search-bars.board-game-search-bar')
	</x-slot>


    <x-slot name="imageBar">
        <x-image-bar :image="$boardGame->box_img" noImage="images/board-game-no-image.webp"
            alt="{{ __('Board game image') }}" class="rounded-lg border" />
    </x-slot>


    <x-slot name="pageHeader">
        <h2> <x-rpg-pawn /> {{ $boardGame->name }} </h2>
    </x-slot>


    <x-slot name="infoBar">
        @include('board-game.show.info-bar')
    </x-slot>


    <div class="flex flex-col justify-center gap-8 md:gap-16 sm:flex-row py-4">

        @if (!empty($boardGame->box_img))
            <div class="flex min-h-48 max-w-fit justify-center drop-shadow-2xl">
                <img class="m-auto max-h-48 max-w-56 object-contain rounded-lg drop-shadow-2xl sm:m-0 md:max-w-64 lg:max-w-96" src="{{ asset('storage/' . $boardGame->box_img) }}" alt="{{ __('Board game') }}">
            </div>
        @endif

        <div class="flex flex-col justify-between gap-16">
            <p> {{ $boardGame->description }} </p>
            <p class="flex flex-col gap-x-8 gap-y-2 flex-wrap sm:flex-row sm:justify-between">
                @include('board-game.show.publishers')
            </p>
        </div>

    </div>


    @if ($boardGame->files->count() > 0 || !empty($boardGame->instruction))
        <x-separators.hr-accent-color class="mt-8" />
        <section class="flex flex-row flex-wrap justify-center items-center gap-x-24 gap-y-8 px-4 pt-8 pb-4">
            @include('board-game.show.files')
        </section>
    @endif


    @if (!empty($relatedGames))
        <x-separators.hr-accent-color class="mt-8"/>
        <section class="flex flex-col gap-y-2 px-2 py-4">
            <h3 class="text-center mb-4">{{ __($relatedGames['title']) }}</h3>
            <div class="flex flex-row flex-wrap justify-center items-end gap-8 md:gap-16">
                @foreach ($relatedGames['games'] as $game)
                    <x-box-game-img :game="$game" />
                @endforeach
            </div>
        </section>
    @endif


    @if ($boardGame->sleeves->count() > 0)
        <x-separators.hr-accent-color class="mt-8" />
        <section class="flex flex-col gap-y-2 px-2 py-4">
            <h3 class=" text-center mb-4">{{ __('Sleeves') }}</h3>
            <div class="flex flex-row flex-wrap justify-center gap-8 md:gap-16">
                @include('board-game.show.sleeves')
            </div>
        </section>
    @endif


    @if(!empty($mediaContents = $boardGame->getMultimediaContent()))
        <x-separators.hr-accent-color class="mt-8" />
        <section class="flex flex-row flex-wrap justify-center gap-8 px-2 pt-8 pb-4 md:gap-16">
            @foreach ($mediaContents as $name => $url)
                <a class="shadow-md hover:animate-pulse" href="{{ $url }}">
                    <img class="h-16 w-auto" src="{{ asset("images/logos/$name.png") }}" alt="{{ $name }}">
                </a>
            @endforeach
        </section>
    @endif


    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('board-game.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

        @can('isAdmin')
            <div class="flex flex-wrap justify-center gap-8">
                <a class="btn info" href="{{ route('board-game-sleeve.index', $boardGame) }}" title="{{ __('Sleeves') }}">
                    <x-rpg-fire-shield /> {{ __('Sleeves') }}
                </a>

                <a class="btn info" href="{{ route('board-game.files', $boardGame) }}" title="{{ __('Files') }}">
                    <x-icon-multiple-pages /> {{ __('Files') }}
                </a>

                <x-buttons.edit href="{{ route('board-game.edit', $boardGame) }}">
                    {{ __('Edit') }}
                </x-buttons.edit>

                <x-forms.delete action="{{ route('board-game.destroy', $boardGame) }}" content="{{ $boardGame->name }}" />
            </div>
        @endcan
    </x-sections.action-footer>

</x-app-layout>
