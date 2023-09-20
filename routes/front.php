<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');
$features = config('site-settings.enables_features');
$front_registrar = null;

if(is_installed()) {
    $front_registrar = front_registrar();

    if(!empty($c) && request()->segment(1) != $c['prefix'] || !empty($c) && $headless) {
        Route::group([], function ($router) use ($c, $features, $front_registrar) {
            $router->get('/images/{folder?}/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
            $router->get('/images/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
            // $router->get('/', 'App\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
            // $router->get('{slug}', 'App\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show');
            // $router->bind('slug', 'App\Adminify\Http\Controllers\Front\PageController@handleSlug');

            $fileGenerated_paths = $front_registrar->getRoutes();
            if(!empty($fileGenerated_paths)) {
                foreach ($fileGenerated_paths as $key => $path) {
                    # code...
                    include($path);
                }
            }

            if(isset($features['form']) && $features['form']) {
                $router->post('/forms/validate/', 'App\Adminify\Http\Controllers\Front\PageController@validateForms')->name('forms.validate');
            }

        });
    }

    if(isset($features['pwa']) && $features['pwa']) {
        $router->get('manifest.json', 'App\Adminify\Http\Controllers\Front\PageController@getManifest')->name('manifest');
    }

}


