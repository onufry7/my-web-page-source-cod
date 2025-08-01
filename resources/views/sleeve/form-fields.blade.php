{{-- Mark --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sleeves mark') }}"
        type="text"
        name="mark"
        value="{{ old('mark', $sleeve->mark ?? '') }}"
        minlength="2"
        maxlength="150"
        required
        class="w-full" />
</div>

{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sleeves name') }}"
        type="text"
        name="name"
        value="{{ old('name', $sleeve->name ?? '') }}"
        minlength="2"
        maxlength="150"
        required
        class="w-full" />
</div>

{{-- Width --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sleeves width') }}"
        type="number"
        name="width"
        value="{{ old('width', $sleeve->width ?? '') }}"
        min="5"
        required
        class="w-full"
    />
</div>

{{-- Height --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sleeves height') }}"
        type="number"
        name="height"
        value="{{ old('height', $sleeve->height ?? '') }}"
        min="5"
        required
        class="w-full" />
</div>

{{-- Quantity available --}}
@if (empty($sleeve) || empty($sleeve->id))
    <div class="col-span-6">
        <x-forms.input
            label="{{ __('Quantity available') }}"
            type="number"
            name="quantity_available"
            value="{{ old('quantity_available', $sleeve->quantity_available ?? '') }}"
            min="0"
            class="w-full" />
    </div>
@endif

{{-- Thickness --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sleeves thickness in microns') }} (µm)"
        type="number"
        name="thickness"
        value="{{ old('thickness', $sleeve->thickness ?? '') }}"
        min="1"
        class="w-full" />
</div>

{{-- Image upload --}}
<div class="col-span-6">
    <x-forms.image-field-upload
        label="{{ __('Sleeves image') }}"
        fieldId="image_file"
        fieldValue="{{ $sleeve->image_path ?? '' }}"
        deleteFieldId="delete_image_file"
        acceptFileTypes="image/png, image/jpeg, image/webp"
    />
</div>
