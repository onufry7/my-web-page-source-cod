@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span {{ $attributes->wire('then') }} x-data x-ref="span" x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);">
    {{ $slot }}
</span>

@once
    <x-popups.dialog-modal wire:model.live="confirmingPassword">
        <x-slot name="title">
            {{ $title }}
        </x-slot>

        <x-slot name="content">
            {{ $content }}

            <div class="my-2" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
                <input class="my-1 block w-full" type="password" placeholder="{{ __('Password') }}" autocomplete="current-password" x-ref="confirmable_password"
                    wire:model="confirmablePassword" wire:keydown.enter="confirmPassword" />

                <x-forms.input-error class="mt-2" for="confirmable_password" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-buttons.cancel type="button" wire:click="stopConfirmingPassword" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-buttons.cancel>

            <x-buttons.confirm type="button" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled">
                {{ $button }}
            </x-buttons.confirm>
        </x-slot>
    </x-popups.dialog-modal>
@endonce
