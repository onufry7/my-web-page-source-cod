@props(['name', 'label', 'options', 'optionName', 'selected' => [], 'valueName' => 'id', 'emptyMessage' => __('No options to select')])

<label for="{{ $name }}">
    {{ $label }}:
    @if($attributes->has('required'))
        <span class="requiredStar">*</span>
    @endif
</label>

<select id="{{ $name }}" name="{{ $name }}[]" multiple {{ $attributes }}>
    @forelse ($options as $option)
        <option value="{{ $option->$valueName }}" @selected(collect($selected)->contains($option->$valueName))>
            {{ __($option->$optionName) }}
        </option>
    @empty
        <option disabled>{{ $emptyMessage }}</option>
    @endforelse
</select>

<x-forms.input-error for="{{ $name }}" />
