<x-forms.section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6 sm:col-span-4">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input class="my-1 block w-full" id="current_password" type="password" wire:model="state.current_password" autocomplete="current-password" />
            <x-forms.input-error class="mt-2" for="current_password" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="password">{{ __('New Password') }}</label>
            <input class="my-1 block w-full" id="password" type="password" wire:model="state.password" autocomplete="new-password" />
            <x-forms.input-error class="mt-2" for="password" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input class="my-1 block w-full" id="password_confirmation" type="password" wire:model="state.password_confirmation"
                autocomplete="new-password" />
            <x-forms.input-error class="mt-2" for="password_confirmation" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-buttons.save type="submit">
            {{ __('Save') }}
        </x-buttons.save>

        <x-actions.message class="flex items-center justify-center" on="saved">
            {{ __('Saved.') }}
        </x-actions.message>
    </x-slot>
</x-forms.section>
