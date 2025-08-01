<x-app-layout>

    <x-slot name="header">
        {{ __('Sleeves') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-rpg-gold-bar /> {{ __('Edit stock sleeves') }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('sleeve.stock-update', $sleeve) }}" method="PATCH">

        <x-slot name="title">
            <h3 class="ml-4 mb-8">{{ __('Sleeve') }}: {{ $sleeve->getFullName() }}</h3>

            <p class="text-muted mb-8 ml-8 text-sm block">
                {{ __('If the option „Correction” is checked, the entered value will replace the current stock. Otherwise, it will be added to it') }}.
            </p>
        </x-slot>

        <x-slot name="form" x-data="{ showDescriptionField: false, minQty: 1 }">

            {{-- Quantity available --}}
            <div class="col-span-6 sm:col-span-4">
                <x-forms.input
                    label="{{ __('Quantity available') }}"
                    type="number"
                    name="quantity_available"
                    value="{{ old('quantity_available') }}"
                    min="0"
                    required
                    x-bind:min="minQty"
                    class="w-full"
                />
            </div>

            {{-- Correction --}}
            <div class="col-span-2">
                <x-forms.checkbox
                    label="{{ __('Correct') }}"
                    labelClass="inline-flex flex-col flex-wrap items-center gap-4"
                    name="correct"
                    x-on:click="showDescriptionField = $event.target.checked; minQty = $event.target.checked ? 0 : 1;"
                />
            </div>

            {{-- Description --}}
            <div class="col-span-6" x-show="showDescriptionField">
                <x-forms.input
                    label="{{ __('Description') }}"
                    type="text"
                    name="description"
                    value="{{ old('description') }}"
                    class="w-full"
                />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-buttons.cancel href="{{ route('sleeve.show', $sleeve) }}">
                {{ __('Cancel and Back') }}
            </x-buttons.cancel>

            <x-buttons.save type="submit">
                {{ __('Update') }}
            </x-buttons.save>
        </x-slot>
    </x-forms.classic>

</x-app-layout>
