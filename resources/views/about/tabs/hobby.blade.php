<h3 class="py-4 text-center">{{ __('Privately') }}</h3>

<ul class="space-y-8">

	<li>
		<span class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center" title="{{ __('Pokemon GO') }}">
			<x-icon-pokeball class="h-8 w-auto" /> <b>Pokemon GO:</b> 8010 1646 4745
		</span>
	</li>

	<li>
		<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary"
			href="https://boardgamegeek.com/collection/user/onufry7?gallery=large&rankobjecttype=subtype&rankobjectid=1&columns=title%7Cthumbnail&geekranks=Board%20Game%20Rank&wanttoplay=1&objecttype=thing&ff=1&subtype=boardgame"
			title="{{ __('Want to play') }}" target="_blank">
			<x-icon-archery class="h-8 w-auto" /> {{ __('Board games I want to play') }}
		</a>
	</li>

	<li>
		<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary"
			href="https://boardgamegeek.com/collection/user/onufry7?gallery=large&sort=wishlist&sortdir=asc&rankobjecttype=subtype&rankobjectid=1&columns=title%7Cthumbnail&geekranks=Board%20Game%20Rank&wanttobuy=1&wishlist=1&wishlistpriority=3&objecttype=thing&ff=1&subtype=boardgame"
			title="{{ __('Interesting games') }}" target="_blank">
			<x-icon-position class="h-8 w-auto" /> {{ __('Board games that interested me') }}
		</a>
	</li>

	<li>
		<a class="flex flex-col flex-wrap items-center justify-center gap-2 sm:flex-row sm:gap-4 text-center link secondary" href="https://cubes.szymon.page" title="{{ __('Rubic Cubes') }}" target="_blank">
			<x-icon-rubic class="h-8 w-auto" /> {{ __('Rubic Cubes') }}
		</a>
	</li>

</ul>
