<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$headless = config('site-settings.headless');

if(isset($c) && request()->segment(1) != $c['prefix'] || isset($c) && $headless) {
    Route::middleware('multilang.basic')->group(function ($router) {
        $router->get('/', 'Ludows\Adminify\Http\Controllers\Front\PageController@index')->name('pages.front.index');
        $router->get('{slug}', 'Ludows\Adminify\Http\Controllers\Front\PageController@getPages')->where('slug', '([A-Za-z0-9\-\/]+)')->name('pages.front.show')->middleware('front.blogpage');
        $router->bind('slug', 'Ludows\Adminify\Http\Controllers\Front\PageController@handleSlug');
    });
}



