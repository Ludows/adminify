<?php
use Illuminate\Support\Facades\Route;

Route::get('/sitemap/{sitemapPart?}', 'Ludows\Adminify\Http\Controllers\Back\SitemapController@index')->name('sitemap.index');
