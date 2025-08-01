{{-- URL --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Link') }}"
        type="text"
        name="url"
        value="{{ old('url', $accessToken->url ?? route('register')) }}"
        maxlength="255"
        required
        class="w-full"
    />
</div>

{{-- Expires at --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Expires') }}"
        type="datetime-local"
        name="expires_at"
        value="{{ old('expires_at', $accessToken->expires_at ?? '') }}"
        required
        class="w-full"
    />
</div>

{{-- Email --}}
<div class="col-span-6">
    <x-forms.input
        label="{{ __('Email') }}"
        type="email"
        name="email"
        value="{{ old('email', $accessToken->email ?? '') }}"
        maxlength="255"
        required
        class="w-full"
    />
</div>
