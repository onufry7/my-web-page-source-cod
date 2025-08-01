<x-app-layout>

    <x-slot name="header">
        {{ __('Board games') }}
    </x-slot>

    <x-slot name="imageBar">
        <x-image-bar :image="$boardGame->box_img" noImage="images/board-game-no-image.webp" alt="{{ __('Board game image') }}" class="rounded-lg border" />
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-plus /> {{ __('Adding sleeves') }}: {{ $boardGame->name }} </h2>
    </x-slot>

    <x-forms.classic action="{{ route('board-game-sleeve.store', $boardGame) }}">

        <x-slot name="form">

            <input id="board_game_id" type="hidden" name="board_game_id" value="{{ $boardGame->id }}" />

            {{-- Mark --}}
            <div class="col-span-6 md:col-span-3">
                <x-forms.select
                    label="{{ __('Sleeves') }}"
                    name="sleeve_id"
                    :options="$sleeves"
                    optionName="label"
                    required
                    class="w-full"
                    selected="{{ old('sleeve_id') }}"
                />
            </div>

            {{-- Quantity --}}
            <div class="col-span-6 md:col-span-3">
                <x-forms.input
                    label="{{ __('Quantity') }}"
                    id="quantity"
                    name="quantity"
                    type="number"
                    min="0"
                    value="{{ old('quantity') }}"
                    required
                    aria-placeholder="Chose a sleeves"
                    class="w-full"
                />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-buttons.backward href="{{ route('board-game-sleeve.index', $boardGame) }}">
                {{ __('To list') }}
            </x-buttons.backward>

            <x-buttons.save type="submit">
                {{ __('Save') }}
            </x-buttons.save>
        </x-slot>

    </x-forms.classic>

</x-app-layout>
