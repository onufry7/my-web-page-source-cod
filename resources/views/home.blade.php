<x-app-layout>

	<x-slot name="header">
		{{ __('Welcome on the page') }}!
	</x-slot>

	<nav class="my-8 flex flex-col flex-wrap justify-around gap-4">

		<div class="my-8 flex flex-row flex-wrap justify-around gap-8">
			<a class="tile-btn" href="{{ route('project.index') }}" title="{{ __('Projects') }}">
				<x-rpg-mining-diamonds class="h-10 w-auto" /> <span>{{ __('Projects') }}</span>
			</a>

			<a class="tile-btn" href="{{ route('cipher.index') }}" title="{{ __('Ciphers') }}">
				<x-rpg-rune-stone class="h-10 w-auto" /> <span>{{ __('Ciphers') }}</span>
			</a>

			<a class="tile-btn" href="{{ route('board-game.index') }}" title="{{ __('Board games') }}">
				<x-rpg-pawn class="h-10 w-auto" /> <span>{{ __('Board games') }}</span>
			</a>
		</div>

		<div class="flex flex-row flex-wrap justify-around">
			<div class="home-btn" title="{{ __('You are hear!') }}">
				<x-icon-home class="size-10" />
			</div>
		</div>

		<div class="my-8 flex flex-row flex-wrap justify-around gap-8">
			<a class="tile-btn" href="{{ route('about') . '#about' }}" title="{{ __('About Me') }}">
				<x-icon-about class="h-10 w-auto" /> <span>{{ __('About Me') }}</span>
			</a>

			<a class="tile-btn" href="{{ route('about') . '#contact' }}" title="{{ __('Contact') }}">
				<x-icon-at class="h-10 w-auto" /> <span>{{ __('Contact') }}</span>
			</a>

			<a class="tile-btn" href="{{ route('about') . '#brand' }}" title="{{ __('Branding') }}">
				<x-icon-academic-cap class="h-10 w-auto" /> <span>{{ __('Branding') }}</span>
			</a>

			<a class="tile-btn" href="{{ route('about') . '#hobby' }}" title="{{ __('Hobby') }}">
				<x-icon-arcade class="h-10 w-auto" /> <span>{{ __('Hobby') }}</span>
			</a>
		</div>

	</nav>

</x-app-layout>
