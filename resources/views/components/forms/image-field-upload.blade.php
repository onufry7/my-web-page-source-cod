@props([
    'label' => 'Image',
    'fieldId' => 'image_file',
    'fieldValue' => '',
    'deleteFieldId' => 'delete_image_file',
    'acceptFileTypes' => 'image/*',
])


<div x-data="{ imageName: null, imagePreview: null, removeImg: false }">

    <label for="{{ $fieldId }}" class="my-2">
        {{ $label }}:
        @if($attributes->has('required'))
            <span class="requiredStar">*</span>
        @endif
    </label>

    <div class="relative rounded-lg my-0" :class="removeImg && 'ring-8 ring-inset ring-red-500'">

        {{-- Nowy obrazek (podgląd) --}}
        <template x-if="imagePreview">
            <label class="img-upload-label" for="{{ $fieldId }}" aria-hidden="true">
                <img class="h-60 object-scale-down p-1" :src="imagePreview" alt="{{ __($label) }}">
            </label>
        </template>

        {{-- Istniejący obrazek (z serwera) --}}
        @if ($fieldValue)
            <template x-if="!imagePreview">
                <label class="img-upload-label" for="{{ $fieldId }}" aria-hidden="true">
                    <span :class="removeImg && 'imageToDelete'">
                        <img class="h-60 object-scale-down p-1"
                            src="{{ asset('storage/' . $fieldValue) }}"
                            alt="{{ __($label) }}"
                             />
                    </span>
                </label>
            </template>

            {{-- Przełącznik usunięcia obrazka --}}
            <template x-if="!imagePreview">
                <label class="m-0" for="{{ $deleteFieldId }}" aria-hidden="true">
                    <div class="pin-btn danger size-10 right-2 top-2" x-show="!removeImg">
                        <x-icon-trash class="size-full m-2" />
                    </div>
                    <div class="pin-btn primary size-10 right-2 top-2" x-show="removeImg">
                        <x-icon-refresh class="size-full m-1" />
                    </div>
                </label>
            </template>

            <input type="checkbox" class="hidden" id="{{ $deleteFieldId }}" name="{{ $deleteFieldId }}"
                x-ref="{{ $deleteFieldId }}"
                x-on:change="removeImg = $refs.{{ $deleteFieldId }}.checked" />
        @else
            {{-- Brak obrazka --}}
            <template x-if="!imagePreview">
                <label class="img-upload-label" for="{{ $fieldId }}" aria-hidden="true">
                    <div class="pin-btn success size-18">
                        <x-icon-add-photo class="size-full m-3" />
                    </div>
                </label>
            </template>
        @endif

        {{-- Przycisk usuwania podglądu --}}
        <div class="pin-btn warning size-10 right-2 top-2" x-show="imagePreview"
            x-on:click="$refs.{{ $fieldId }}.value = ''; imagePreview = null;">
            <x-icon-remove-photo class="size-full m-1" />
        </div>
    </div>

    {{-- Pole pliku --}}
    <input class="mt-0 w-full" type="file" id="{{ $fieldId }}" name="{{ $fieldId }}" {{ $attributes }}
        accept="{{ $acceptFileTypes }}"
        x-ref="{{ $fieldId }}"
        x-on:change="
            if ($refs.{{ $deleteFieldId }}) {
                $refs.{{ $deleteFieldId }}.checked = false;
                removeImg = false;
            }
            const file = $refs.{{ $fieldId }}.files[0];
            if (!file) {
                imagePreview = null;
            } else {
                imageName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => imagePreview = e.target.result;
                reader.readAsDataURL(file);
            }
        " />

    <x-forms.input-error for="{{ $fieldId }}" />

</div>
