<a {{ $attributes->merge(['class' => 'btn info']) }} title="{{ __('Show') }}">
	<x-icon-eye /> {{ $slot }}
</a>
