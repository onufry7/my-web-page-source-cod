{{-- Cipher Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Cipher name') }}"
        type="text"
        name="name"
        value="{{ old('name', $cipher->name ?? '') }}"
        minlength="1"
        maxlength="100"
        required
        class="w-full"
    />

    @if (!$errors->has('name') && $errors->has('slug'))
        <x-forms.input-error for="slug" />
    @endif
</div>

{{-- Sub Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Additional name') }}"
        type="text"
        name="sub_name"
        value="{{ old('sub_name', $cipher->sub_name ?? '') }}"
        maxlength="100"
        class="w-full"
    />
</div>

{{-- File HTM --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('File HTM') }}"
        type="file"
        name="file"
        accept="text/html"
        class="w-full"
        :required="empty($cipher) || !$cipher->id"
    />
</div>

{{-- Cover image --}}
<div class="col-span-6">
    <x-forms.image-field-upload
        label="{{ __('Cover image') }}"
        fieldId="cover_image"
        fieldValue="{{ $cipher->cover ?? '' }}"
        deleteFieldId="delete_cover"
        acceptFileTypes="image/png, image/jpeg, image/webp"
    />
</div>
