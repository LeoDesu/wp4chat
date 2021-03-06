<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ config('app.env', 'local') == 'local'? asset('/storage/img/white-chat-square-dots.png'):secure_asset('/storage/img/white-chat-square-dots.png') }}">

    <!-- Scripts -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ config('app.env', 'local') == 'local'? asset('css/app.css'):secure_asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <script src="{{ config('app.env', 'local') == 'local'? asset('js/app.js'):secure_asset('js/app.js') }}" defer></script>
</body>
</html>
