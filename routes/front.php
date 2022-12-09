<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');
$features = config('site-settings.enables_features');
$front_registrar = null;
$themeManager = null;

if(is_installed()) {
    $themeManager = theme_manager();
    $front_registrar = front_registrar();

    if(!empty($c) && request()->segment(1) != $c['prefix'] || !empty($c) && $headless) {
        Route::middleware('multilang.basic')->group(function ($router) use ($c, $themeManager, $features, $front_registrar) {

            $theme = theme();

            $router->get('/images/{folder?}/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
            $router->get('/images/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
            // $router->get('/', 'App\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
            // $router->get('{slug}', 'App\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show');
            // $router->bind('slug', 'App\Adminify\Http\Controllers\Front\PageController@handleSlug');

            $fileGenerated = $front_registrar->getRoutes();
            if(!empty($fileGenerated)) {
                include($fileGenerated);
            }

            if(!empty($theme)) {
                $router->get('/theme/{folder}/{filename}', 'App\Adminify\Http\Controllers\Front\ImageController@themeAssets')->name('theme.assets');
            }

            // dd($features);


            if(isset($features['form']) && $features['form']) {
                $router->post('/forms/validate/', 'App\Adminify\Http\Controllers\Front\PageController@validateForms')->name('forms.validate');
            }

            if(isset($c['pwa']) && $c['pwa']) {
                $router->get('manifest.json', 'App\Adminify\Http\Controllers\Front\PageController@getManifest')->name('manifest');
            }


            // $path_admin_file = base_path('routes/adminify_front.php');

            // if(file_exists($path_admin_file)){
            //     include($path_admin_file);
            // }
            if(is_installed()) {
                $fileRoutes_in_themes = $themeManager->getFileRoutes('front');
                include($fileRoutes_in_themes);
            }

        });
    }

}


