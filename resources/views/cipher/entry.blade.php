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
        <h2> <x-rpg-rune-stone /> {{ __('Entry') }} </h2>
    </x-slot>


    <article class="mx-auto my-4 prose dark:prose-invert">

        <section>
            <h3 class="my-4 border-b border-accent-cipher px-4">O dziale...</h3>
            <p class="px-4">
                Ten dział strony jest poświęcony różnym metodą szyfrowania, nie mam namyśli tutaj żadnych kodów typu IDEA, DES czy AES - choć może i takie
                też
                się pojawią,
                ale szyfrów typu gaderypoluki, cezara czy alfabet Morse'a, których można użyć przy grze terenowej lub do zabawy.
            </p>
            <p class="px-4">
                Każdy szyfr zostanie omówiony i opisany w mam nadzieję łatwy do zrozumienia sposób, tak abyś po przeczytaniu potrafił/a zaszyfrować i
                odszyfrować coś za jego pomocą.
            </p>
            <p class="text-center px-4">
                Życzę miłej i owocnej lektury.
            </p>
        </section>



        <section>
            <h3 class="my-4 border-b border-accent-cipher px-4">Krótka teoria...</h3>
            <p class="px-4">
                Nie będę tutaj mówił na tematy informatyczne i matematyczne szyfrowania, lecz ujmę tutaj kilka przydatnych uwag.
            </p>

            <p class="px-4">
                Jeśli chcesz odszyfrować zaszyfrowaną wiadomość to zwróć uwagę na to, iż w każdym języku są pewne grupy liter, które często występują w
                słowach
                w języku polskim taką grupę tworzą samogłoski poza tym samogłoska „I” występuje jako pojedynczy wyraz. Znając takie i podobne reguły można w
                łatwy sposób odgadnąć, jakich znaków użyto do zaszyfrowania tych liter (o ile nie uwzględniono tego w szyfrowaniu). <br>
                Dla przykładu: <br>
                Zdanie: Ala ma kota i psa. <br>
                Po zaszyfrowaniu: 1,15,1; 17,1; 14,20,26,1; 12; 22,24,1; <br>
                Można teraz wysnuć wniosek, że cyfra 1 odpowiada jakiejś z samogłosek a 12 może być literą i, a lub w etc.
            </p>

            <p class="px-4">Taka znajomość języka bardzo się przydaje w łamaniu hasła również znajomość przyzwyczajeń osoby szyfrującej jest przydatna.</p>

            <p class="px-4">
                Jeśli jakiś szyfr nie posiada polskich liter to zastępujemy je bezogonkowymi odpowiednikami tj, jeśli chcemy zaszyfrować ę, ą, ż, etc. a nie
                mamy ich w szyfrze to zastępujemy je odpowiednio przez e, a ,z, etc.
            </p>
            <p class="px-4">
                Przy opisywaniu szyfrów będę stosował takie nazwy: <br>
                Tekst jawny - oznacza tekst, który będzie poddany szyfrowaniu. <br>
                Szyfrogram - tekst po zaszyfrowaniu, zaszyfrowany tekst. <br>
                Słowo klucz - oznacza to dowolne słowo, które sam wymyślisz. <br>
                Niektóre szyfry będą posiadać dodatkową pomoc tj. szablon za pomocą, którego będziemy szyfrować z reguły ich pierwsza linia oznacza tekst
                jawny a druga szyfrogram tak, więc jeśli na górze znajdziemy literę A a pod nią będzie D to oznaczać to będzie, że literę A zaszyfrujemy
                jako D
                <br>
                Tekst jawny = A, szyfrogram = D, czyli A = D
            </p>

            <p class="text-center px-4">
                Mam nadzieję, że jakoś sobie poradzisz &#128521;
            </p>
        </section>

    </article>


    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('cipher.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>
    </x-sections.action-footer>

</x-app-layout>
