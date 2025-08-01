{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Project name') }}"
        type="text"
        name="name"
        value="{{ old('name', $project->name ?? '') }}"
        minlength="3"
        maxlength="160"
        required
        class="w-full"
    />

    @if (!$errors->has('name') && $errors->has('slug'))
        <x-forms.input-error for="slug" />
    @endif
</div>

{{-- Url --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link to project') }}"
        type="url"
        name="url"
        value="{{ old('url', $project->url ?? '') }}"
        maxlength="255"
        required
        class="w-full"
    />
</div>

{{-- Git --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link to GIT') }}"
        type="url"
        name="git"
        value="{{ old('git', $project->git ?? '') }}"
        maxlength="255"
        class="w-full"
    />
</div>

{{-- Description --}}
<div class="col-span-6">
    <x-forms.textarea
        label="{{ __('Description') }}"
        name="description"
        value="{{ old('description', $project->description ?? '') }}"
        class="w-full"
        rows="8"
        maxlength="4500"
    />
</div>

{{-- Category --}}
<div class="col-span-6">
    <x-forms.select
        label="{{ __('Category') }}"
        name="category"
        :options="$categories::cases()"
        optionName="name"
        valueName="value"
        required
        class="w-full"
        selected="{{ old('category', $project->category ?? '') }}"
        :emptyFirstOptions=false
        x-model="selectedCategory"
    />
</div>

{{-- Technologies --}}
<div class="col-span-6" x-show="selectedCategory == '{{ $categories::Coding->value }}' || selectedCategory == ''">
    <x-forms.select-multiple
        label="{{ __('Technologies') }}"
        name="technologies"
        :options="$technologies"
        optionName="name"
        :selected="old('technologies', isset($project) ? $project->technologies->pluck('id')->toArray() : [])"
        class="w-full h-64"
    />
</div>

{{-- Image upload --}}
<div class="col-span-6">
    <x-forms.image-field-upload
        label="{{ __('Project image') }}"
        fieldId="image"
        fieldValue="{{ $project->image_path ?? '' }}"
        deleteFieldId="delete_image"
        acceptFileTypes="image/png, image/jpeg, image/webp"
    />
</div>

{{-- For registered --}}
<div class="col-span-6 flex">
    <x-forms.checkbox
        label="{{ __('For registered') }}"
        labelClass="inline-flex flex-row flex-wrap items-center gap-2"
        name="for_registered"
        :checked="old('for_registered', $project->for_registered ?? '')"
    />
</div>
