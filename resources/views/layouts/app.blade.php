<!DOCTYPE html>
<html lang="{{ lang() }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="{{ asset('') }}/favicon.png" rel="icon" type="image/png">
        {!! SEO::generate() !!}
        @inertiaHead
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @hook('assets.css')

        @if ($page['props']['siteConfig']['assets']['vitejs'])
            @foreach ($page['props']['siteConfig']['assets']['inputs'] as $input)
                @vite($page['props']['siteConfig']['assets'][$input])
            @endforeach
        @endif

        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        @inertia
        @hook('assets.js')
        @stack('js')
    </body>
</html>

