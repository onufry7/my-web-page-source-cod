<x-guest-layout>
    <x-authentications.card>

        <div class="my-4 text-sm">
            {{ __("Before you proceed, please verify your email address by clicking the link we sent you. If you haven't received an email, we'll be happy to send you another one.") }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="my-2 text-sm font-normal bg-success p-2 rounded-md">
                {{ __('A new verification tab-link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        <div class="my-2 flex flex-col items-center justify-center gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn primary" type="submit">
                    <x-icon-airplane /> {{ __('Resend Verification Email') }}
                </button>
            </form>

            <div class="flex flex-col gap-4 w-full sm:flex-row sm:justify-between">
                <a class="link flex flex-row gap-2" href="{{ route('profile.show') }}">
                    <span>{{ __('Edit Profile') }}</span> <x-icon-pencil class="h-6 w-auto" />
                </a>

                <form class="inline" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="link flex flex-row gap-2" type="submit">
                        <span>{{ __('Log Out') }}</span> <x-icon-logout class="h-6 w-auto" />
                    </button>
                </form>
            </div>
        </div>
    </x-authentications.card>
</x-guest-layout>
