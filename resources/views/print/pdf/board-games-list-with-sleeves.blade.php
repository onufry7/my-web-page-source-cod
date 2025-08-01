<!DOCTYPE html>
<html lang="pl">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lista Planszówek z koszulkami</title>
	<style>
		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: normal;
			src: url('{{ storage_path('fonts/Lato-Regular.ttf') }}') format('truetype');
		}

		@font-face {
			font-family: 'Lato';
			font-style: normal;
			font-weight: bold;
			src: url('{{ storage_path('fonts/Lato-Bold.ttf') }}') format('truetype');
		}

		body {
			font-family: 'Lato';
            font-size: 12pt;
		}

		ul {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}

        h1 {
            font-size: 16pt;
        }

        h2 {
            font-size: 14pt;
            font-weight: bold;
            margin: 0;
			padding: 0;
            text-decoration: underline;
        }
	</style>
</head>

<body>
	<h1>Lista Planszówek z koszulkami</h1>
    <hr>
    <br>
	@foreach ($games as $game)
        <h2>{{ $game->name }}:</h2>
        <ul>
			@foreach ($game->sleeves as $sleeve)
				<li>
					{{ $sleeve->getfullName() }} ({{ $sleeve->getSize() }}): {{ $sleeve->pivot->quantity }} szt.
				</li>
			@endforeach
	    </ul>
        <br>
    @endforeach
</body>

</html>
