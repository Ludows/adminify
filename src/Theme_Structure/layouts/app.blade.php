<!DOCTYPE html>
<html lang="{{ lang() }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="{{ asset('') }}/favicon.png" rel="icon" type="image/png">
        {!! SEO::generate() !!}

        <meta name="csrf-token" content="{{ csrf_token() }}">
        @laravelPWA
        @hook('assets.css')
        {!! Assets::css( get_site_key('assets.render.css') ) !!}
        @stack('css')

        <script>
            window.adminify_exports = {!! $export !!};
        </script>
    </head>
    <body class="{{ $class ?? '' }}">
        <main id="app">
            <root-sharing :export="{{ $export ?? '{}' }}"></root-sharing>
            @if($topbarShow)
                {!! toolbar() !!}
            @endif
            @if(!$isTemplate)
                @include('theme::'. $theme .'.layouts.partials.header')
            @endif
            @yield('content')
            @if(!$isTemplate)
                @include('theme::'. $theme .'.layouts.partials.footer')
            @endif
        </main>

        @stack('modales')
        @hook('assets.js')
        {!! Assets::js( get_site_key('assets.render.js') ) !!}
        @stack('js')
    </body>
</html>
