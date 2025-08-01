<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="description"
		content="Witaj na mojej prywatnej stronie internetowej! Tutaj znajdziesz moje portfolio programistyczne,
        które obejmuje różnorodne aplikacje i gry stworzone w różnych językach programowania. Dodatkowo, prezentuję również listę moich
        ulubionych gier planszowych. W serwisie przedstawiam również proste metody szyfrowania. Zachęcam do odwiedzenia strony, aby
        dowiedzieć się więcej o moich projektach programistycznych, pasji do gier planszowych, prostych technikach szyfrowania.">
	<meta name="keywords" content="Szymon Burnejko, Onufry, portfolio programistyczne, moja lista gier planszowych, gry planszowe,
        instrukcje do gier planszowych, metody szyfrowania, proste metody szyfrowania, proste szyfry, szyfry, szymon.page">
	<meta name="robots" content="index, nofollow">
	<meta name="author" content="Szymon Burnejko">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
		{{ config('app.name') }} @yield('title')
	</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192x192.png">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com" rel="preconnect">
	<link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,400&display=swap" rel="stylesheet">

	<script src="{{ asset('js/dark-mode.js') }}"></script>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	@livewireStyles

</head>

<body class="{{ $bgClass }} flex min-h-screen flex-col justify-between font-sans antialiased body-text-color body-bg">

	<div class="space-y-8">
		<div class="shadow-500/50 sticky top-0 z-40 border-b border-gray-100 bg-slate-200/95 shadow-sm backdrop-blur-md backdrop-filter dark:border-gray-700 dark:bg-slate-900/95" x-data="{ open: false }">
			<x-menu.primary />
			<x-menu.responsive />
            <x-separators.hr-accent-color class="container" size="h-0.5" />
			{{ Breadcrumbs::render() }}
		</div>

        <x-popups.banner />

		<div class="container rounded-2xl flex flex-col gap-2 px-4 py-2 bg-slate-100/90 dark:bg-slate-800/90">
			@if (isset($header))
                <h1 class="text-center">
                    {{ $header }}
                </h1>
			@endif

			@if (isset($searchBar))
				<div class="mx-auto px-4 w-full md:w-3/4">
					{{ $searchBar }}
				</div>
			@endif
		</div>

		<main class="container overflow-hidden rounded-2xl px-2 sm:px-4 pb-24 pt-2 bg-slate-100/90 dark:bg-slate-800/90">

            @if (isset($imageBar)) {{ $imageBar }} @endif

            @if (isset($pageHeader))
                <header class="page-header border-{{ $accentColor }}">
                    {{ $pageHeader }}
                </header>
            @endif

            @if (isset($infoBar)) {{ $infoBar }} @endif

            <article class="mt-8"> {{ $slot }} </article>
		</main>
	</div>

	<footer class="mt-18 shadow-500/50 z-40 min-h-10 border-t border-gray-100 bg-slate-200 opacity-95 shadow-md backdrop-blur-md backdrop-filter dark:border-gray-700 dark:bg-slate-900">
		<span class="flex flex-row flex-wrap justify-center px-4 py-2 text-sm">
			Created by <a class="no-underline" href="{{ route('about') }}">Szymon Burnejko</a> &copy; 2024 - {{ date('Y') }}
		</span>
	</footer>

	@stack('modals')

	@livewireScriptConfig
</body>

</html>
