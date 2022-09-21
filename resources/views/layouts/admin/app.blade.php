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
        @hook('assets.css')
        {!! Assets::css( get_site_key('assets.render.css') ) !!}
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
            @include('adminify::layouts.admin.navbars.sidebar')
        @endauth

        <div class="main-content">
            @if(!is_auth_routes())
                @include('adminify::layouts.admin.navbars.navbar')
            @endif

            @yield('content')
        </div>

        @if(!is_auth_routes())
            @include('adminify::layouts.admin.modales.globalSearch')
        @endif
        @stack('modales')
        @hook('assets.js')
        {!! Assets::js( get_site_key('assets.render.js') ) !!}
        @stack('js')

    </body>
</html>
