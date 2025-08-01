<section class="simple-menu">
    <ul class="border-accent-cipher list-inside">
        <li class="border-accent-cipher">
            <a href="{{ route('cipher.entry') }}">
                <x-rpg-speech-bubble class="size-8" /> {{ __('Entry') }}
            </a>
        </li>
        <li class="border-accent-cipher">
            <a href="{{ route('cipher.catalog') }}">
                <x-rpg-quill-ink class="size-8" /> {{ __('Index') }}
            </a>
        </li>
    </ul>
</section>
