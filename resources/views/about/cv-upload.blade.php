<x-app-layout>

    <x-slot name="header">
        {{ __('Update CV') }}
    </x-slot>

    <form action="{{ route('cv.upload') }}" method="post" enctype="multipart/form-data">

        @csrf

        <div class="mx-4 my-8">
            <label class="text-center" for="cv">{{ __('CV File') }}:</label>
            <input class="w-full" id="cv" name="cv" type="file" accept="application/pdf" required />
            <x-forms.input-error for="cv" />
        </div>

        <div class="flex justify-center">
            <button type="submit" class="btn success">
                <x-icon-arrow-up-tray /> {{ __('Upload CV') }}
            </button>
        </div>

    </form>

</x-app-layout>
