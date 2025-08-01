{{-- User ID --}}
<x-forms.input type="hidden" name="user_id" value="{{ old('user_id', $gameplay->user_id ?? auth()->id()) }}" />

{{-- Date --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Date') }}"
        type="date"
        name="date"
        value="{{ old('date', $gameplay?->dateForForm() ?? $gameplay->date ?? '') }}"
        required
        class="w-full"
    />
</div>

{{-- Name --}}
<div class="col-span-6">
    <x-forms.select
        label="{{ __('Base game') }}"
        name="board_game_id"
        :options=$baseGames
        optionName="name"
        required
        class="w-full"
        selected="{{ old('board_game_id', $gameplay->board_game_id ?? '') }}"
    />
</div>


{{-- Gameplays count --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Number of gameplays') }}"
        type="number"
        name="count"
        value="{{ old('count', $gameplay->count ?? '') }}"
        min="1"
        max="200"
        required
        class="w-full"
    />
</div>
