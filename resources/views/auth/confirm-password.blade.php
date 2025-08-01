<x-guest-layout>
    <x-authentications.card :hideQuoteMarque="true">

        <div class="my-4 text-sm">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="my-4 block ">
                <input class="w-full" id="password" name="password" type="password" placeholder="{{ __('Password') }}" autocomplete="current-password" required autofocus />
            </div>

            <div class="mt-4 flex justify-between gap-4">
                <x-buttons.backward href="{{ route('password.confirm.back') }}">
                    {{ __('Return') }}
                </x-buttons.backward>

                <x-buttons.confirm type="submit">
                    {{ __('Confirm') }}
                </x-buttons.confirm>
            </div>
        </form>
    </x-authentications.card>
</x-guest-layout>
