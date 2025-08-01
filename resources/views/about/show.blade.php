<x-app-layout>

	<x-slot name="header">
		{{ __('My Profile') }}
	</x-slot>

	<div x-data="{ tab: window.location.hash.slice(1) || 'about' }">

		<img class="mx-auto h-32 w-32 rounded-full object-cover shadow-xl" src="{{ asset('images/my-photo.webp') }}" alt="Autor">

		<h2 class="my-4 flex justify-center">Szymon Burnejko</h2>

		<div class="flex flex-wrap justify-center gap-4 xl:gap-8">
			<a class="link secondary px-2 py-4" href="#about" title="{{ __('About Me') }}" x-on:click="tab = 'about'" x-bind:class="{ 'active': tab === 'about' }">
				<x-icon-about class="h-12 w-auto" />
			</a>

			<a class="link secondary px-2 py-4" href="#contact" title="{{ __('Contact') }}" x-on:click="tab = 'contact'" x-bind:class="{ 'active': tab === 'contact' }">
				<x-icon-at class="h-12 w-auto" />
			</a>

			<a class="link secondary px-2 py-4" href="#brand" title="{{ __('Work') }}" x-on:click="tab = 'brand'" x-bind:class="{ 'active': tab === 'brand' }">
				<x-icon-academic-cap class="h-12 w-auto" />
			</a>

			<a class="link secondary px-2 py-4" href="#hobby" title="{{ __('Hobby') }}" x-on:click="tab = 'hobby'" x-bind:class="{ 'active': tab === 'hobby' }">
				<x-icon-arcade class="h-12 w-auto" />
			</a>
		</div>

		<div class="relative rounded-b-xl border-t p-4 border-{{ $accentColor }}" x-show="['about', 'contact', 'brand', 'hobby'].includes(tab)" x-transition:enter="transition ease-out duration-600" x-transition:enter-start="opacity-0 origin-top scale-y-0"
			x-transition:enter-end="opacity-100 origin-top scale-y-100" x-transition:leave="transition ease-out duration-500" x-transition:leave-start="opacity-100 origin-top scale-y-100" x-transition:leave-end="opacity-0 origin-top scale-y-0">

			<div style="display: none;" x-show="tab === 'about'">
				@include('about.tabs.about-me')
			</div>

			<div style="display: none;" x-show="tab === 'contact'">
				@include('about.tabs.contact')
			</div>

			<div style="display: none;" x-show="tab === 'brand'">
				@include('about.tabs.branding')
			</div>

			<div style="display: none;" x-show="tab === 'hobby'">
				@include('about.tabs.hobby')
			</div>

		</div>

	</div>

</x-app-layout>
