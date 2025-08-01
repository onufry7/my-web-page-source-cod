<x-app-layout>

    <x-slot name="header">
        {{ __('Users') }}
    </x-slot>

    <x-slot name="pageHeader">
        <h2> <x-icon-user/> {{ $user->name }} </h2>
    </x-slot>

    <div class="flex flex-col gap-4 md:flex-row">

        @if ($user->profile_photo_path)
            <img class="max-h-36 max-w-36 object-contain m-4" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ __('Profile photo') }}">
        @else
            <x-icon-profile-circle class="h-36 w-auto" />
        @endif

        <div class="dataRow">
            <p>
                {{ __('User nick') }}: <span>{{ $user->nick }}</span>
            </p>
            <p>
                {{ __('Permissions') }}: <span>{{ __($user->getNameRole()) }}</span>
            </p>
            <p>
                {{ __('User email') }}: <span>{{ $user->email }}</span>
            </p>
            <p>
                {{ __('User email verified at') }}: <span>{{ $user->email_verified_at }}</span>
            </p>

            <x-sections.timestamps :model="$user" />
        </div>
    </div>

    <x-sections.action-footer>
        <div class="flex flex-wrap justify-center">
            <x-buttons.backward href="{{ route('user.index') }}">
                {{ __('To list') }}
            </x-buttons.backward>
        </div>

        <div class="flex flex-wrap justify-center gap-8">
            <a class="btn warning" href="{{ route('user.switch-role', $user) }}">
                <x-icon-shield-alert /> {{ __('Change permissions') }}
            </a>
            <x-forms.delete action="{{ route('user.destroy', $user) }}" content="{{ __('User') . ': ' . $user->name }}" />
        </div>
    </x-sections.action-footer>

</x-app-layout>
