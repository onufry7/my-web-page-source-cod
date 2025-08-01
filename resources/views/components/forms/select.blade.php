@props(['name', 'label', 'options', 'optionName', 'selected', 'valueName' => 'id', 'emptyMessage' => __('No options to select'), 'emptyFirstOptions' => true])


<label for="{{ $name }}">
    {{ $label }}:
    @if($attributes->has('required'))
        <span class="requiredStar">*</span>
    @endif
</label>

<select id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
    @if($emptyFirstOptions)
        <option class="my-1 cursor-pointer rounded-md px-2 py-1" value=""> --- </option>
    @endif

    @forelse ($options as $option)
        <option class="my-1 cursor-pointer rounded-md px-2 py-1" value="{{ $option->$valueName }}"
            @selected($option->$valueName == $selected)>
            {{ __($option->$optionName) }}
        </option>
    @empty
        <option disabled>{{ $emptyMessage }}</option>
    @endforelse
</select>

<x-forms.input-error for="{{ $name }}" />
