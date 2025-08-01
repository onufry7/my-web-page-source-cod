{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Technology name') }}"
        type="text"
        name="name"
        value="{{ old('name', $technology->name ?? '') }}"
        minlength="3"
        maxlength="60"
        required
        class="w-full" />
</div>
