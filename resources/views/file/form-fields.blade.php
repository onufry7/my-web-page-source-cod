{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('File name') }}"
        type="text"
        name="name"
        value="{{ old('name', $file->name ?? '') }}"
        maxlength="255"
        required
        class="w-full"
    />
</div>

@if(empty($file) || empty($file->id))

    {{-- File --}}
    <div class="col-span-6">
        <x-forms.input
            label="{{ __('File') }}"
            type="file"
            name="file"
            accept="application/pdf"
            required
            class="w-full"
        />
    </div>


    {{-- Model type --}}
    <x-forms.input type="hidden" name="model_type" value="{{ $model::class }}" />

    {{-- Model ID --}}
    <x-forms.input type="hidden" name="model_id" value="{{ $model->id }}" />
@endif
