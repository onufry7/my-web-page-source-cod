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
	</style>
</head>

<body>
	<h1>Lista koszulek użytych w grach</h1>
    <hr>
	<ul>
		@foreach ($boardGameSleeves as $pivot)
			<li>
				{{ $pivot->sleeve->getfullName() }} ({{ $pivot->sleeve->getSize() }}): {{ $pivot->quantity ?? 0 }} szt.
			</li>
		@endforeach
	</ul>
</body>

</html>
