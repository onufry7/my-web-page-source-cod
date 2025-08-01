<x-guest-layout>
    <x-authentications.card>

        <div x-data="{ recovery: false }">
            <div class="my-4 text-sm" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="my-4 text-sm" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="my-4 block" x-show="! recovery">
                    <input class="w-full" id="code" name="code" type="text" inputmode="numeric" autofocus x-ref="code"
                        autocomplete="one-time-code" placeholder="{{ __('Authentication Code') }}" />
                </div>

                <div class="my-4 block" x-cloak x-show="recovery">
                    <input class="w-full" id="recovery_code" name="recovery_code" type="text" x-ref="recovery_code"
                        autocomplete="one-time-code" placeholder="{{ __('Recovery Code') }}" />
                </div>

                <div class="mt-4 flex justify-between gap-4">
                    <button class="link" type="button" x-show="! recovery"
                        x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button class="link" type="button" x-cloak x-show="recovery"
                        x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <button class="btn primary" type="submit">
                        <x-icon-login /> {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </x-authentications.card>
</x-guest-layout>
