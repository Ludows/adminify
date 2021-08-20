<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! SEO::generate() !!}
        <!-- Favicon -->
        <link href="{{ asset('adminify') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('adminify') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('adminify') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('adminify/back') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('adminify/back') }}/css/extensions.css" rel="stylesheet">
        @stack('css')
        @php
            $fullmode = isset($fullmode) ? $fullmode : false;
        @endphp
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @if(!$fullmode)
                @include('adminify::layouts.admin.navbars.sidebar')
            @endif
        @endauth

        <div class="main-content">
            @if(!$fullmode)
                @include('adminify::layouts.admin.navbars.navbar')
            @endif
           
            @yield('content')
        </div>

        @guest()
            @include('adminify::layouts.admin.footers.guest')
        @endguest

        {{--  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>  --}}
        <script src="{{ asset('myuploads') }}/routes.js"></script>
        <script src="{{ asset('adminify/back') }}/js/extensions.js"></script>
        {{--  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>  --}}

        @include('adminify::layouts.admin.modales.globalSearch')
        @stack('modales')
        @stack('js')

        <!-- Argon JS -->
        <script src="{{ asset('adminify/back') }}/js/extensions-call.js"></script>
        <script src="{{ asset('adminify/back') }}/js/argon.js?v=1.0.0"></script>
        <script src="{{ asset('adminify/back') }}/js/searchable.js"></script>

    </body>
</html>
