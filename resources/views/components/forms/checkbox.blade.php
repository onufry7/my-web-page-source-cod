@props(['label', 'name', 'labelClass' => '', 'checked' => old($name)])

<label class="{{ $labelClass }}" for="{{ $name }}">
    <span>
        {{ $label }}:
        @if($attributes->has('required'))
            <span class="requiredStar">*</span>
        @endif
    </span>

    <input id="{{ $name }}" name="{{ $name }}" type="checkbox" @checked($checked) {{ $attributes }} />
</label>
<x-forms.input-error for="{{ $name }}" />
