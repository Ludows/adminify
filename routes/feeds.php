<?php
use Illuminate\Support\Facades\Route;

Route::group(function ($router) {
    $router->get('/feeds/{slug}', 'Ludows\Adminify\Http\Controllers\Back\FeedsController@index')->name('feed.index');
});