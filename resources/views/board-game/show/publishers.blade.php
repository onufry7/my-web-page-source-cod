@foreach ($publishers as $label => $publisher)
    @if ($publisher)
        <span>
            {{ __($label) }}:
            @if ($publisher->website)
                <a class="no-underline" href="{{ $publisher->website }}" title="{{ __('Publisher website') }}">
                    <b>{{ $publisher->name }}</b>
                </a>
            @else
                <b>{{ $publisher->name }}</b>
            @endif
        </span>
    @endif
@endforeach
