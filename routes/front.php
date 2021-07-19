<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');

if(request()->segment(1) != $c['prefix'] || $headless) {
    Route::middleware('multilang.basic')->group(function ($router) {
        $router->get('/', 'Ludows\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
        $router->get('{slug}', 'Ludows\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show')->middleware('pages.front.pages');
        $router->bind('slug', 'Ludows\Adminify\Http\Controllers\Front\PageController@handleSlug');
    });
}



