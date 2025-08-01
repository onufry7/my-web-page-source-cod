<x-actions.section>
    <x-slot name="title">
        {{ __('Browser Sessions') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Manage and log out your active sessions on other browsers and devices.') }}
    </x-slot>

    <x-slot name="content">
        <div class="text-muted max-w-xl text-sm">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-4 space-y-6">
                <!-- Other Browser Sessions -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <svg class="text-muted h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                </svg>
                            @else
                                <svg class="text-muted h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                </svg>
                            @endif
                        </div>

                        <div class="ml-3">
                            <div class="text-muted text-sm">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} -
                                {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                            </div>

                            <div>
                                <div class="text-muted text-xs">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="font-bold text-green-700 dark:text-green-400">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-5 flex items-center gap-4">
            <button class="btn warning" type="submit" wire:click="confirmLogout" wire:loading.attr="disabled">
                <x-icon-pc-no-entry /> {{ __('Log Out Other Browser Sessions') }}
            </button>

            <x-actions.message on="loggedOut">
                {{ __('Done.') }}
            </x-actions.message>
        </div>

        <!-- Log Out Other Devices Confirmation Modal -->
        <x-popups.dialog-modal wire:model.live="confirmingLogout">
            <x-slot name="title">
                {{ __('Log Out Other Browser Sessions') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                <div class="mt-4" x-data="{}"
                    x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                    <input class="my-2 block w-full" type="password" autocomplete="current-password" placeholder="{{ __('Password') }}" x-ref="password"
                        wire:model="password" wire:keydown.enter="logoutOtherBrowserSessions" />

                    <x-forms.input-error class="mt-2" for="password" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-buttons.cancel type="button" wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-buttons.cancel>

                <x-buttons.confirm type="button" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                    {{ __('Log Out Other Sessions') }}
                </x-buttons.confirm>
            </x-slot>
        </x-popups.dialog-modal>
    </x-slot>
</x-actions.section>
