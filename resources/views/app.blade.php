<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @if($__env->yieldContent('title') === 'Index')
            Phaser 3 API Documentation (beta) - @yield('title')
        @else
            @yield('title') - Phaser 3 API Documentation (beta)
        @endif
    </title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Adobe Fonts -->
    <script src="//use.typekit.net/fmc0gtt.js"></script>
    <script>
        try{Typekit.load();}catch(e){}
    </script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YQ8ZV78C86"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-YQ8ZV78C86');
    </script>
</head>

<body class="antialiased">
    @yield('content')

    @include('footer')
</body>

</html>
