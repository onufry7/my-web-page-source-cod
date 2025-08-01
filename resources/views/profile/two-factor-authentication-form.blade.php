<x-actions.section>
    <x-slot name="title">
        {{ __('Two Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Add additional security to your account using two factor authentication.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-normal">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>

        <div class="my-2 max-w-xl text-sm text-muted">
            {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-muted">
                    <p class="font-bold">
                        @if (!$showingConfirmation)
                            {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                        @else
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                        @endif
                    </p>
                </div>

                <div class="mt-4 inline-block bg-white p-2">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>

                <div class="mt-4 max-w-xl text-sm text-muted">
                    <p class="font-bold">
                        {{ __('Setup Key') }}: {{ decrypt($this->user->two_factor_secret) }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <label for="code">{{ __('Code') }}</label>

                        <input class="my-2 block w-1/2" id="code" name="code" type="text" inputmode="numeric" autofocus autocomplete="one-time-code"
                            wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" />

                        <x-forms.input-error class="mt-2" for="code" />
                    </div>
                @endif
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-muted">
                    <p class="font-bold">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>
                </div>

                <div class="mt-4 grid max-w-xl gap-1 rounded-lg bg-gray-200 text-gray-800 px-4 py-4 font-mono text-sm dark:bg-gray-900 dark:text-gray-100">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-4 box-container">
            @if (!$this->enabled)
                <x-popups.confirms-password wire:then="enableTwoFactorAuthentication">
                    <button class="btn success" type="button" wire:loading.attr="disabled">
                        <x-icon-power /> {{ __('Enable') }}
                    </button>
                </x-popups.confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-popups.confirms-password wire:then="regenerateRecoveryCodes">
                        <button class="btn warning" type="button">
                            <x-icon-refresh /> {{ __('Regenerate Recovery Codes') }}
                        </button>
                    </x-popups.confirms-password>
                @elseif ($showingConfirmation)
                    <x-popups.confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-buttons.confirm type="button" wire:loading.attr="disabled">
                            {{ __('Confirm') }}
                        </x-buttons.confirm>
                    </x-popups.confirms-password>
                @else
                    <x-popups.confirms-password wire:then="showRecoveryCodes">
                        <button class="btn info" type="button">
                            <x-icon-eye /> {{ __('Show Recovery Codes') }}
                        </button>
                    </x-popups.confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-popups.confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-buttons.cancel type="button" wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-buttons.cancel>
                    </x-popups.confirms-password>
                @else
                    <x-popups.confirms-password wire:then="disableTwoFactorAuthentication">
                        <button class="btn danger" type="button" wire:loading.attr="disabled">
                            <x-icon-power /> {{ __('Disable') }}
                        </button>
                    </x-popups.confirms-password>
                @endif

            @endif
        </div>
    </x-slot>
</x-actions.section>
