{{-- Name --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Board game name') }}"
        type="text"
        name="name"
        value="{{ old('name', $boardGame->name ?? '') }}"
        minlength="1"
        maxlength="255"
        required
        class="w-full"
    />
    @if (!$errors->has('name') && $errors->has('slug'))
        <x-forms.input-error for="slug" />
    @endif
</div>

{{-- Image upload --}}
<div class="col-span-6">
    <x-forms.image-field-upload
        label="{{ __('Board game image box') }}"
        fieldId="box_image"
        fieldValue="{{ $boardGame->box_img ?? '' }}"
        deleteFieldId="delete_box_img"
        acceptFileTypes="image/png, image/jpeg, image/webp"
    />
</div>

{{-- Description --}}
<div class="col-span-6">
    <x-forms.textarea
        label="{{ __('Description') }}"
        name="description"
        value="{{ old('description', $boardGame->description ?? '') }}"
        class="w-full"
        rows="8"
        maxlength="4500"
    />
</div>

{{-- Type --}}
<div class="col-span-6">
    <x-forms.select
        label="{{ __('Type') }}"
        name="type"
        :options="$boardGameType::cases()"
        optionName="name"
        valueName="value"
        required
        class="w-full"
        selected="{{ old('type', $boardGame->type ?? '') }}"
        :emptyFirstOptions="false"
        x-model="selectedType"
    />
</div>

{{-- BaseGame ID --}}
<div class="col-span-6" x-show="selectedType && selectedType != '{{ $boardGameType::BaseGame->value }}'">
    <x-forms.select
        label="{{ __('Base game') }}"
        name="base_game_id"
        :options="$baseGames"
        optionName="name"
        required
        class="w-full"
        selected="{{ old('base_game_id', $boardGame->base_game_id ?? '') }}"
        x-bind:disabled="!selectedType || selectedType == '{{ $boardGameType::BaseGame->value }}'"
    />
</div>

{{-- Min players --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Min. Players') }}"
        type="number"
        name="min_players"
        value="{{ old('min_players', $boardGame->min_players ?? '') }}"
        min="1"
        max="125"
        step="1"
        class="w-full"
    />
</div>

{{-- Max players --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Max. Players') }}"
        type="number"
        name="max_players"
        value="{{ old('max_players', $boardGame->max_players ?? '') }}"
        min="1"
        max="125"
        step="1"
        class="w-full"
    />
</div>

{{-- Game time --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Game time') }}"
        type="number"
        name="game_time"
        value="{{ old('game_time', $boardGame->game_time ?? '') }}"
        min="5"
        max="1200"
        step="5"
        class="w-full"
    />
</div>

{{-- Age --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Age') }}"
        type="number"
        name="age"
        value="{{ old('age', $boardGame->age ?? '') }}"
        min="0"
        max="199"
        step="1"
        class="w-full"
    />
</div>

{{-- Publisher --}}
<div class="col-span-6">
    <x-forms.select
        label="{{ __('Publisher') }}"
        name="publisher_id"
        :options="$publishers"
        optionName="name"
        class="w-full"
        selected="{{ old('publisher_id', $boardGame->publisher_id ?? '') }}"
    />
</div>

{{-- Original Publisher --}}
<div class="col-span-6">
    <x-forms.select
        label="{{ __('Original publisher') }}"
        name="original_publisher_id"
        :options="$publishers"
        optionName="name"
        class="w-full"
        selected="{{ old('original_publisher_id', $boardGame->original_publisher_id ?? '') }}"
    />
</div>

{{-- Instruction --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Instruction') }}"
        type="file"
        name="instruction_file"
        accept="application/pdf"
        class="w-full"
    />

    @if ($boardGame->instruction ?? false)
        <x-forms.checkbox
            label="{{ __('Delete current instruction') }}"
            labelClass="inline-flex flex-row flex-wrap items-center gap-2"
            name="delete_instruction"
        />
    @endif
</div>

{{-- Video url --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link to video') }}"
        type="url"
        name="video_url"
        value="{{ old('video_url', $boardGame->video_url ?? '') }}"
        maxlength="255"
        class="w-full"
    />
</div>

{{-- BGG url --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link to BGG') }}"
        type="url"
        name="bgg_url"
        value="{{ old('bgg_url', $boardGame->bgg_url ?? '') }}"
        maxlength="255"
        class="w-full"
    />
</div>

{{-- Planszeo url --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link to Planszeo') }}"
        type="url"
        name="planszeo_url"
        value="{{ old('planszeo_url', $boardGame->planszeo_url ?? '') }}"
        maxlength="255"
        class="w-full"
    />
</div>

{{-- Potrzebny insert --}}
<div class="col-span-6 md:col-span-2">
    <x-forms.checkbox
        label="{{ __('Needed insert') }}"
        labelClass="inline-flex flex-row flex-wrap items-center gap-2"
        name="need_insert"
        :checked="old('need_insert', $boardGame->need_insert ?? '')"
    />
</div>

{{-- Do malowania --}}
<div class="col-span-6 md:col-span-2">
    <x-forms.checkbox
        label="{{ __('To painting') }}"
        labelClass="inline-flex flex-row flex-wrap items-center gap-2"
        name="to_painting"
        :checked="old('to_painting', $boardGame->to_painting ?? '')"
    />
</div>

{{-- Wymaga instrukcji --}}
<div class="col-span-6 md:col-span-2">
    <x-forms.checkbox
        label="{{ __('Needed instruction') }}"
        labelClass="inline-flex flex-row flex-wrap items-center gap-2"
        name="need_instruction"
        :checked="old('need_instruction', $boardGame->need_instruction ?? 'on')"
    />
</div>
