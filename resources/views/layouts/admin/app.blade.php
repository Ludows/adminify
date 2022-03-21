<!DOCTYPE html>
<html lang="{{ lang() }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        {!! SEO::generate() !!}
        <!-- Favicon -->
        <link href="{{ asset('adminify') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->

        <!-- Icons -->
        <!-- Argon CSS -->
        {!! Assets::css() !!}
        @stack('css')

        <script>
            window.siteSettings = @json($request->siteConfig)
        </script>

    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            {{-- @if(!$loadEditor) --}}
                @include('adminify::layouts.admin.navbars.sidebar')
            {{-- @endif --}}
        @endauth

        <div class="main-content">
            @if(!is_auth_routes())
                @include('adminify::layouts.admin.navbars.navbar')
            @endif

            @yield('content')
        </div>

        {!! Assets::js() !!}
        {{--  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>  --}}
        {{-- <script src="{{ asset('myuploads') }}/routes.js"></script>
        <script src="{{ asset('adminify/back') }}/js/extensions.js"></script>
        <script src="{{ asset('myuploads') }}/traductions-{{ str_replace('_', '-', app()->getLocale()) }}.js"></script> --}}
        {{--  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>  --}}

        @include('adminify::layouts.admin.modales.globalSearch')
        @stack('modales')
        @stack('js')


        {{-- <!-- Argon JS -->
        <script src="{{ asset('adminify/back') }}/js/extensions-call.js"></script>
        <script src="{{ asset('adminify/back') }}/js/argon.js?v=1.0.0"></script>
        <script src="{{ asset('adminify/back') }}/js/searchable.js"></script> --}}

    </body>
</html>
