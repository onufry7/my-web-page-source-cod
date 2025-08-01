@props(['name', 'label' => null])

@if($label !== null)
    <label for="{{ $name }}">
        {{ $label }}:
        @if($attributes->has('required'))
            <span class="requiredStar">*</span>
        @endif
    </label>
@endif

<input id="{{ $name }}" name="{{ $name }}" {{ $attributes }} />

<x-forms.input-error :for="$name" />
