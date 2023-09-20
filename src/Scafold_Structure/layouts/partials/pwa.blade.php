@php
    $config = $page['props'];
@endphp
@if ( $config['enabled_features']['pwa'])
    <!-- Web Application Manifest -->
    {{-- {{ dd($pwa) }} --}}
    <link rel="manifest" href="{{ route('manifest') }}">
    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="{{ $config['pwa']['_settings_pwa_theme_color'] }}">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="{{ $config['pwa']['_settings_pwa_display'] == 'standalone' ? 'yes' : 'no' }}">
    <meta name="application-name" content="{{ $config['pwa']['_settings_pwa_shortname'] ?? '' }}">
    <link rel="icon" sizes="{{ data_get(end( $config['pwa']['_settings_pwa_icons']), 'sizes') }}" href="{{ data_get(end($config['pwa']['_settings_pwa_icons']), 'src') }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="{{ $config['pwa']['_settings_pwa_display'] == 'standalone' ? 'yes' : 'no' }}">
    <meta name="apple-mobile-web-app-status-bar-style" content="{{  $config['pwa']['_settings_pwa_status_bar'] ?? 'black' }}">
    <meta name="apple-mobile-web-app-title" content="{{ $config['pwa']['_settings_pwa_shortname'] ?? '' }}">
    <link rel="apple-touch-icon" href="{{ data_get(end($config['pwa']['_settings_pwa_icons']), 'src') }}">


    {{-- <link href="{{ $config['splash']['640x1136'] }}" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['750x1334'] }}" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1242x2208'] }}" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1125x2436'] }}" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['828x1792'] }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1242x2688'] }}" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1536x2048'] }}" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1668x2224'] }}" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['1668x2388'] }}" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="{{ $config['splash']['2048x2732'] }}" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" /> --}}

    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker-{{ $config["lang"] }}.js', {
                scope: '.'
            }).then(function (registration) {
                // Registration was successful
                console.log('Adminify PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function (err) {
                // registration failed :(
                console.log('Adminify PWA: ServiceWorker registration failed: ', err);
            });
        }
    </script>
@endif
