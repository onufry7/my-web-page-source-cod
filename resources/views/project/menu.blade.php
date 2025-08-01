<section class="simple-menu" x-data="{ tab: new URLSearchParams(location.search).get('kategoria') || 'all' }">
    <ul class="border-accent-project list-inside">
        <li class="border-accent-project">
            <a href="{{ route('project.index') }}" x-bind:class="{ 'active': tab === 'all' }">
                <x-rpg-bomb-explosion class="size-8" /> {{ __('All') }}
            </a>
        </li>
        <li class="border-accent-project">
            <a href="{{ route('project.index', ['kategoria' => strtolower($categories::Coding->value)]) }}"
                x-bind:class="{ 'active': tab === '{{ strtolower($categories::Coding->value) }}' }">
                <x-rpg-scroll-unfurled class="size-8" /> {{ __('Codding') }}
            </a>
        </li>
        <li class="border-accent-project">
            <a href="{{ route('project.index', ['kategoria' => strtolower($categories::Ciphers->value)]) }}"
                x-bind:class="{ 'active': tab === '{{ strtolower($categories::Ciphers->value) }}' }">
                <x-rpg-rune-stone class="size-8" /> {{ __('Ciphers') }}
            </a>
        </li>
        <li class="border-accent-project">
            <a href="{{ route('project.index', ['kategoria' => strtolower($categories::Games->value)]) }}"
                x-bind:class="{ 'active': tab === '{{ strtolower($categories::Games->value) }}' }">
                <x-rpg-pawn class="size-8" /> {{ __('Board games') }}
            </a>
        </li>
        <li class="border-accent-project">
            <a href="{{ route('project.index', ['kategoria' => strtolower($categories::Others->value)]) }}"
                x-bind:class="{ 'active': tab === '{{ strtolower($categories::Others->value) }}' }">
                <x-rpg-diamond class="size-8" /> {{ __('Others') }}
            </a>
        </li>
    </ul>
</section>


