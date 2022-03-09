<!DOCTYPE html>
<html lang="{{ lang() }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="{{ asset() }}/favicon.png" rel="icon" type="image/png">
        {!! SEO::generate() !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">

       
        <!-- Fonts -->
        {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"> --}}
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        {{-- <link href="{{ asset('adminify') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet"> --}}
        {{-- <link href="{{ asset('adminify') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet"> --}}
        <!-- Argon CSS -->
        {{-- <link type="text/css" href="{{ asset('adminify/front') }}/css/argon.css?v=1.0.0" rel="stylesheet"> --}}
        {{-- <link type="text/css" href="{{ asset('adminify/front') }}/css/front.css?v=1.0.0" rel="stylesheet"> --}}
        @laravelPWA
        {!! Assets::group('frontend')->css() !!}
        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        <main id="app">
            <div id="swup">
                <root-sharing :export="{{ $export ?? '{}' }}"></root-sharing>

                @php
                    $topbarPref = get_user_preference('topbar');
                    $topbarShow = false;

                    //dd($topbarPref);
                    if($topbarPref != null) {
                        $topbarShow = (bool)$topbarPref;
                    }
                @endphp
                @if($topbarShow)
                    {!! toolbar() !!}
                @endif
                @include('adminify::layouts.front.navbars.navbar')
                @yield('content')

                @include('adminify::layouts.front.footers.nav')
            </div>
        </main>
        {{--  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>  --}}
        {{-- <script src="{{ asset('myuploads') }}/routes.js"></script> --}}
        {{-- <script src="{{ asset('adminify/front') }}/js/app.js"></script> --}}
        {{-- <script src="{{ asset('myuploads') }}/traductions-{{ str_replace('_', '-', app()->getLocale()) }}.js"></script> --}}
        {{--  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>  --}}

        @stack('modales')
        @stack('js')
        {!! Assets::group('frontend')->js() !!}

        <!-- Argon JS -->
    </body>
</html>
