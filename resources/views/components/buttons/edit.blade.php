<a {{ $attributes->merge(['class' => 'btn primary']) }} title="{{ __('Edit') }}">
	<x-icon-pencil /> {{ $slot }}
</a>
