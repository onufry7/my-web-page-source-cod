<x-app-layout>

	<x-slot name="header">
		{{ __('Access tokens') }}
	</x-slot>

	<x-slot name="pageHeader">
		<h2> <x-icon-finger-print /> {{ $accessToken->token }} </h2>
	</x-slot>

	<div class="dataRow">
		<p>
			{{ __('Token') }}: <span>{{ $accessToken->token }}</span>
		</p>

		<p>
			{{ __('URL') }}: <span>{{ $accessToken->url }}</span>
		</p>

		<p>
			{{ __('Email') }}: <span>{{ $accessToken->email }}</span>
		</p>

        <p>
            {{ __('Expires at') }}: <span>{{ $accessToken->expires_at }}</span>
        </p>

		<p>
			{{ __('Expired') }}:
			<span>{{ $accessToken->isExpired() ? __('Yes') : __('No') }}</span>
			<x-dynamic-component class="{{ $accessToken->isExpired() ? 'text-green-800' : 'text-red-800' }} h-6 w-auto" component="{{ $accessToken->isExpired() ? 'icon-confirm' : 'icon-cancel' }}" />
		</p>

        <p>
            {{ __('Active') }}:
            <span>{{ $accessToken->isActive() ? __('Yes') : __('No') }}</span>
            <x-dynamic-component class="{{ $accessToken->isActive() ? 'text-green-800' : 'text-red-800' }} h-6 w-auto"
                component="{{ $accessToken->isActive() ? 'icon-confirm' : 'icon-cancel' }}" />
        </p>

		<p>
			{{ __('Used') }}:
			<span>{{ $accessToken->is_used ? __('Yes') : __('No') }}</span>
		</p>

		<x-sections.timestamps :model="$accessToken" />
	</div>

	<x-sections.action-footer>
		<div class="flex flex-wrap justify-center">
			<x-buttons.backward href="{{ route('access-token.index') }}">
				{{ __('To list') }}
			</x-buttons.backward>
		</div>

		<div class="flex flex-wrap justify-center gap-8">
			<x-buttons.edit href="{{ route('access-token.edit', $accessToken) }}">
				{{ __('Edit') }}
			</x-buttons.edit>
			<x-forms.delete action="{{ route('access-token.destroy', $accessToken) }}" />
		</div>
	</x-sections.action-footer>

</x-app-layout>
