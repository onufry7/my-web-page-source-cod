{{-- Sentence --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Sentence') }}"
        type="text"
        name="sentence"
        value="{{ old('sentence', $aphorism->sentence ?? '') }}"
        minlength="3"
        maxlength="255"
        required
        class="w-full" />
</div>

{{-- Author --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Author') }}"
        type="text"
        name="author"
        value="{{ old('author', $aphorism->author ?? '') }}"
        maxlength="120"
        class="w-full" />
</div>
