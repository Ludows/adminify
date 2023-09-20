<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings');

if(!empty($c)) {
    Route::get('/sitemap/{part?}', 'App\Adminify\Http\Controllers\Back\SitemapController@index')->name('sitemap.index');
}
