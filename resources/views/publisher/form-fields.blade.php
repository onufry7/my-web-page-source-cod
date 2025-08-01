{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Publisher name') }}"
        type="text"
        name="name"
        value="{{ old('name', $publisher->name ?? '') }}"
        minlength="2"
        maxlength="60"
        required
        class="w-full" />
</div>

{{-- Website --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Publisher website') }}"
        type="url"
        name="website"
        value="{{ old('website', $publisher->website ?? '') }}"
        maxlength="255"
        class="w-full" />
</div>
