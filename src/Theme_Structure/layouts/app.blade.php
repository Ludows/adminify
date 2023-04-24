<!DOCTYPE html>
<html lang="{{ $page['props']['currentLang'] }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="{{ asset('') }}/favicon.png" rel="icon" type="image/png">
        @include('theme::'. $theme .'.layouts.partials.pwa')
        {!! SEO::generate() !!}
        @inertiaHead
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @vite(theme_url().'/src/js/app.js')
        @hook('assets.css')
        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        @inertia
        <script src="{{ asset('/myuploads/routes.js') }}"></script>
        <script src="{{ asset('/myuploads/traductions-'. $page['props']['currentLang'] .'.js') }}"></script>
        @hook('assets.js')
        @stack('js')
    </body>
</html>


