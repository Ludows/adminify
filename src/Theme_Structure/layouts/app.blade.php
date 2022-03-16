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
        @laravelPWA
        {!! Assets::css() !!}
        @stack('css')

        <script>
            window.adminify_exports = @json($export);
        </script>
    </head>
    <body class="{{ $class ?? '' }}">
        <main id="app">
            <div id="swup">
                <root-sharing :export="{{ $export ?? '{}' }}"></root-sharing>
                @if($topbarShow)
                    {!! toolbar() !!}
                @endif
                @include('theme::'. $theme .'.header')
                @yield('content')
                @include('theme::'. $theme .'.footer')
            </div>
        </main>

        @stack('modales')
        {!! Assets::js() !!}
        @stack('js')
    </body>
</html>
