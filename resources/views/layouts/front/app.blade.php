<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {!! SEO::generate() !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon/front') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon/front') }}/css/front.css?v=1.0.0" rel="stylesheet">
        @laravelPWA
        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        <main id="app">
            <div id="swup">
                <root-sharing :user="{{ $user ?? '{}' }}"/>
                @include('adminify::layouts.front.navbars.navbar')
                @yield('content')

                @include('adminify::layouts.front.footers.nav')
            </div>
        </main>
        {{--  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>  --}}
        <script src="{{ asset('myuploads') }}/routes.js"></script>
        <script src="{{ asset('argon/front') }}/js/app.js"></script>
        {{--  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>  --}}

        @stack('modales')
        @stack('js')

        <!-- Argon JS -->
    </body>
</html>
