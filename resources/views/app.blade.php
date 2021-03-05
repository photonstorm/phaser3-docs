<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phaser 3 API Documentation - @yield('title')</title>

    <!-- Adobe Fonts -->
    <script src="//use.typekit.net/fmc0gtt.js"></script>
    <script>try{Typekit.load();}catch(e){}</script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="antialiased">
    @yield('content')

    @include('footer')
</body>

</html>
