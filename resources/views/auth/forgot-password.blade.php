<x-guest-layout>
    <x-authentications.card>

        <div class="my-4 text-sm">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <label for="email">{{ __('Email') }}</label>
                <input class="mt-1 block w-full" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4 flex items-center justify-between gap-4">
                <a class="link text-sm flex flex-row gap-2" href="{{ route('login') }}">
                    {{ __('Logging') }} <x-icon-login class="h-6 w-auto" />
                </a>

                <button class="btn primary" type="submit">
                    <x-icon-airplane /> {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </x-authentications.card>
</x-guest-layout>
