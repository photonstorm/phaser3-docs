<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Phaser 3 API Documentation - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            position: relative;
        }
    </style>
</head>
<body class="antialiased"  data-spy="scroll" data-target="#scrollspy_aside" data-offset="0">
    @include('layouts.menu')

    @yield('content')

    @include('layouts.footer')

    <script>

    </script>
</body>
</html>
