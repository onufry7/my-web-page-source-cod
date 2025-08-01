@props(['name', 'label' => null, 'value' => ''])

@if($label !== null)
    <label for="{{ $name }}">
        {{ $label }}:
        @if($attributes->has('required'))
            <span class="requiredStar">*</span>
        @endif
    </label>
@endif

<textarea id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>{{ $value }}</textarea>

<x-forms.input-error :for="$name" />
