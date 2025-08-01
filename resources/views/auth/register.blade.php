<x-guest-layout>
    <x-authentications.card>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <input id="access-token" name="access-token" type="hidden" value="{{ old('access-token', $request->query('token')) }}" />

            <div>
                <label for="name">{{ __('User name') }}</label>
                <input class="mt-1 block w-full" id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    autocomplete="name" />
            </div>

            <div class="mt-4">
                <label for="nick">{{ __('Nick') }}</label>
                <input class="mt-1 block w-full" id="nick" name="nick" type="text" value="{{ old('nick') }}" autofocus />
            </div>

            <div class="mt-4">
                <label for="email">{{ __('Email') }}</label>
                <input class="mt-1 block w-full" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <label for="terms">
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' . route('terms.show') . '" class="link text-sm">' . __('Terms of Service') . '</a>',
                                    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="link text-sm">' . __('Privacy Policy') . '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </label>
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between gap-4">
                <a class="link text-sm flex flex-row gap-2" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button class="btn primary" type="submit">
                    <x-icon-add-user /> {{ __('Register') }}
                </button>
            </div>
        </form>

    </x-authentications.card>
</x-guest-layout>
