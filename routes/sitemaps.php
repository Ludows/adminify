<?php
use Illuminate\Support\Facades\Route;

Route::group(function ($router) {
    $router->get('/sitemap/{slug}', 'Ludows\Adminify\Http\Controllers\Back\SitemapController@index')->name('sitemap.index');
});
