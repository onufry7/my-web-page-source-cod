@props(['form', 'acctions', 'action', 'method' => 'POST', 'hasFiles' => false])

<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}" action="{{ $action }}" {!! $hasFiles ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes->except(['method', 'action']) }}>

    @method($method)
    @csrf

    <div class="{{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }} px-4 py-5 sm:p-6">
        @if (isset($title)) {{ $title }} @endif
        <div {{ $form->attributes->merge(['class' => 'grid grid-cols-6 gap-6']) }}>
            {{ $form }}
        </div>
    </div>

    @if (isset($actions))
        <div {{ $actions->attributes->merge(['class' => "actions-footer border-$accentColor"]) }}>
            {{ $actions }}
        </div>
    @endif

</form>
