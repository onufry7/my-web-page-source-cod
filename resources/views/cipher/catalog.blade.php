<x-app-layout>

    <x-slot name="header">
        {{ __('Ciphers') }}
    </x-slot>


    <x-slot name="searchBar">
        @livewire('search-bars.cipher-search-bar')
    </x-slot>


    <x-slot name="imageBar">
        <div class="overflow-hidden border-accent-cipher rounded-lg border">
            <img src="{{ asset("images/cipher-no-image.webp") }}" alt="{{ __('Cipher cover') }}" />
        </div>
    </x-slot>


    <x-slot name="pageHeader">
        <h2> <x-rpg-rune-stone /> {{ __('Alphabetical list of ciphers') }} </h2>
    </x-slot>


    <ul class="mx-auto my-4 max-w-lg flex flex-col gap-y-4">
        @forelse ($ciphers as $cipher)
            <li>
                <a href="{{ route('cipher.show', $cipher) }}" class="flex flex-row flex-wrap gap-4 link">
                    <span>{{ $loop->iteration }}.</span> <span>{{ $cipher->name }}</span> <span>{{ $cipher->getSubNameInBrackets() }}</span>
                </a>
            </li>
        @empty
            <li>
                <x-no-data>{{ __('No ciphers') }}.</x-no-data>
            </li>
        @endforelse
    </ul>


    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('cipher.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>
    </x-sections.action-footer>

</x-app-layout>
