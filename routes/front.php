<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');


if(isset($c) && request()->segment(1) != $c['prefix'] || isset($c) && $headless) {
    Route::middleware('multilang.basic')->group(function ($router) {
        $router->get('/', 'Ludows\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
        $router->get('{slug}', 'Ludows\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show');
        $router->bind('slug', 'Ludows\Adminify\Http\Controllers\Front\PageController@handleSlug');

        $router->post('/forms/validate/', 'Ludows\Adminify\Http\Controllers\Front\PageController@validateForms')->name('forms.validate');

        $router->post('/search', 'Ludows\Adminify\Http\Controllers\Front\PageController@search')->name('globalsearch');

        $path_admin_file = base_path('routes/adminify_front.php');

        if(file_exists($path_admin_file)){
            include($path_admin_file);
        }
    });
}



