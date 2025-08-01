<article class="box-tile border-accent-cipher shadow-accent-cipher">

    <div>
        <a class="block" href="{{ route('cipher.show', $cipher) }}">
            <div class="box-tile-img border-accent-cipher">
                <x-image-bar :image="$cipher->cover" noImage="images/cipher-no-image.webp"
                    alt="{{ __('Cipher cover') }}" imgClass="image-bar-responsive" />
            </div>

            <h3 class="border-accent-cipher flex flex-col gap-2">
                <span>{{ Str::title($cipher->name) }}</span>
                <span>{{ $cipher->getSubNameInBrackets() }}</span>
            </h3>
        </a>
    </div>

    <footer>
        <a href="{{ route('cipher.show', $cipher) }}">
            {{ __('More') }} >>
        </a>
    </footer>

</article>
