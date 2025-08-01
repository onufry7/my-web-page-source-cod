<x-actions.section>
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete your account.') }}
    </x-slot>

    <x-slot name="content">

        <div class="max-w-xl text-sm">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-4">
            <button class="btn danger" type="button" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                <x-icon-remove-user /> {{ __('Delete Account') }}
            </button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-popups.dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                {{ __('Delete Account') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input class="mt-1 block w-3/4" type="password" autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                        wire:model="password" wire:keydown.enter="deleteUser" />

                    <x-forms.input-error class="mt-2" for="password" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-buttons.cancel type="button" wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-buttons.cancel>

                <x-buttons.delete type="button" wire:click="deleteUser" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
                </x-buttons.delete>
            </x-slot>
        </x-popups.dialog-modal>

    </x-slot>
</x-actions.section>
