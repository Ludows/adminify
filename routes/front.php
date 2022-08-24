<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');
$themeManager = theme_manager();


if(!empty($c) && request()->segment(1) != $c['prefix'] || !empty($c) && $headless) {
    Route::middleware('multilang.basic')->group(function ($router) use ($c, $themeManager) {

        $theme = theme();

        $router->get('/images/{folder?}/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
        $router->get('/images/{path}', 'App\Adminify\Http\Controllers\Front\ImageController@show')->name('image.transform');
        $router->get('/', 'App\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
        $router->get('{slug}', 'App\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show');
        $router->bind('slug', 'App\Adminify\Http\Controllers\Front\PageController@handleSlug');

        if(!empty($theme)) {
            $router->get('/theme/{folder}/{filename}', 'App\Adminify\Http\Controllers\Front\ImageController@themeAssets')->name('theme.assets');
        }

        $router->post('/forms/validate/', 'App\Adminify\Http\Controllers\Front\PageController@validateForms')->name('forms.validate');

        $router->post('/search', 'App\Adminify\Http\Controllers\Front\PageController@search')->name('globalsearch');

        // $path_admin_file = base_path('routes/adminify_front.php');

        // if(file_exists($path_admin_file)){
        //     include($path_admin_file);
        // }

        $fileRoutes_in_themes = $themeManager->getFileRoutes('front');
        include($fileRoutes_in_themes);
    });
}



