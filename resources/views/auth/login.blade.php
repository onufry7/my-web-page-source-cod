<x-guest-layout>
    <x-authentications.card>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">{{ __('Email') }}</label>
                <input class="mt-1 block w-full" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="current-password" />
            </div>

            <div class="mt-4 block text-center">
                <button class="btn primary" type="submit">
                    <x-icon-login /> {{ __('Log in') }}
                </button>
            </div>

            <div class="mt-4 flex items-center justify-around gap-4">
                <label class="inline-flex cursor-pointer items-center" for="remember_me">
                    <input id="remember_me" name="remember" type="checkbox" />
                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="link rounded-md text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-authentications.card>
</x-guest-layout>
