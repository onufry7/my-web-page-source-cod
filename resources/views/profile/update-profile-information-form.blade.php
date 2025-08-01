@use('Laravel\Jetstream\Jetstream')
@use('Laravel\Fortify\Features')

<x-forms.section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Jetstream::managesProfilePhotos())
            <div class="col-span-6" x-data="{ photoName: null, photoPreview: null }">
                <!-- Profile Photo File Input -->
                <input class="hidden" type="file" wire:model.live="photo" x-ref="photo"
                    x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <label for="photo">{{ __('Photo') }}</label>

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img class="h-20 w-20 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" style="display: none;" x-show="photoPreview">
                    <span class="block h-20 w-20 rounded-full bg-cover bg-center bg-no-repeat"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-2 flex w-full flex-wrap gap-4">
                    <button class="btn secondary" type="button" x-on:click.prevent="$refs.photo.click()">
                        <x-icon-photo /> {{ __('Select photo') }}
                    </button>

                    @if ($this->user->profile_photo_path)
                        <button class="btn danger" type="button" wire:click="deleteProfilePhoto">
                            <x-icon-remove-photo /> {{ __('Remove Photo') }}
                        </button>
                    @endif
                </div>

                <x-forms.input-error class="mt-2" for="photo" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="name">{{ __('User name') }}</label>
            <input class="my-1 block w-full" id="name" type="text" wire:model="state.name" required autocomplete="name" />
            <x-forms.input-error class="mt-2" for="name" />
        </div>

        <!-- Nick -->
        <div class="col-span-6 sm:col-span-4">
            <label for="nick">{{ __('Nick') }}</label>
            <input class="my-1 block w-full" id="nick" type="text" wire:model="state.nick" autocomplete="nick" />
            <x-forms.input-error class="mt-2" for="nick" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <label for="email">{{ __('Email') }}</label>
            <input class="my-1 block w-full" id="email" type="email" wire:model="state.email" required autocomplete="username" />
            <x-forms.input-error class="mt-2" for="email" />

            @if (Features::enabled(Features::emailVerification()) && !$this->user->hasVerifiedEmail())
                <p class="mt-4 text-sm text-muted">
                    {{ __('Your email address is unverified.') }}

                    <button class="link mt-2 inline-flex items-center gap-4 rounded-md text-sm" type="button"
                        wire:click.prevent="sendEmailVerification">
                        <x-icon-airplane /> <span class="text-left">{{ __('Click here to re-send the verification email.') }}</span>
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm font-normal text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-buttons.save type="submit" wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-buttons.save>

        <x-actions.message class="flex items-center justify-center" on="saved">
            {{ __('Saved.') }}
        </x-actions.message>
    </x-slot>
</x-forms.section>
