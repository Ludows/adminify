<!DOCTYPE html>
<html lang="{{ $page['props']['currentLang'] }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Favicon -->
        <link href="{{ asset('') }}/favicon.png" rel="icon" type="image/png">
        {!! SEO::generate() !!}
        @inertiaHead
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @viteReactRefresh
        @vite(['resources/adminify/back/js/extensions.js', 'resources/adminify/back/js/app.jsx', 'resources/adminify/back/sass/extensions.scss', 'resources/adminify/back/sass/app.scss'])
        @hook('assets.css')
        @stack('css')
    </head>
    <body class="{{ $class ?? '' }}">
        @inertia
        @hook('assets.js')
        <script src="{{asset('/myuploads/routes.js')}}"></script>
        <script src="{{ asset('/myuploads/traductions-'. $page['props']['currentLang'] .'.js') }}"></script>
        @stack('js')
    </body>
</html>

