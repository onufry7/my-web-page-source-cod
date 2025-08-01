@section('title', ' - ' . $cipher->name)

<x-app-layout>

	<x-slot name="header">
		{{ __('Ciphers') }}
	</x-slot>


	<x-slot name="searchBar">
		@livewire('search-bars.cipher-search-bar')
	</x-slot>


    <x-slot name="imageBar">
        <x-image-bar :image="$cipher->cover" noImage="images/cipher-no-image.webp" alt="{{ __('Cipher cover') }}"
            class="rounded-lg border" />
    </x-slot>


    <x-slot name="pageHeader">
        <h2> <x-rpg-rune-stone /> {{ $cipher->name }} <div class="text-muted">{{ $cipher->getSubNameInBrackets() }}</div></h2>
    </x-slot>

    <div class="prose dark:prose-invert flex flex-col gap-4 p-4 my-4 mx-auto overflow-x-auto">
        {!! $cipher->content !!}
	</div>


	<x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('cipher.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

        @can('isAdmin')
            <div class="flex flex-wrap justify-center gap-8">
                <x-buttons.edit href="{{ route('cipher.edit', $cipher) }}">
                    {{ __('Edit') }}
                </x-buttons.edit>

                <x-forms.delete action="{{ route('cipher.destroy', $cipher) }}" content="{{ $cipher->name }}" />
            </div>
        @endcan
	</x-sections.action-footer>

</x-app-layout>
