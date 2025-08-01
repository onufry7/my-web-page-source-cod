<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Contact Mail From Page') }}</title>
</head>

<body>
    <h1>{{ __('Contact form with') }} {{ env('APP_NAME', '') }}</h1>
    <p>{{ __('Message from address') }}: <b>{{ $from }}</b></p>
    <p>{{ $messages }}</p>
</body>

</html>
