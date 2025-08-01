<x-guest-layout>
    <x-authentications.card>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input name="token" type="hidden" value="{{ $request->route('token') }}">

            <div class="block">
                <label for="email">{{ __('Email') }}</label>
                <input class="mt-1 block w-full" id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus
                    autocomplete="username" />
            </div>

            <div class="mt-4">
                <label for="password">{{ __('Password') }}</label>
                <input class="mt-1 block w-full" id="password" name="password" type="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                <input class="mt-1 block w-full" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <button class="btn primary" type="submit">
                    <x-icon-refresh /> {{ __('Reset Password') }}
                </button>
            </div>
        </form>

    </x-authentications.card>
</x-guest-layout>
