<?php
use Illuminate\Support\Facades\Route;

Route::get('/{slug}', 'Ludows\Adminify\Http\Controllers\Front\PageController@show')->name('pages.front.show');
Route::get('/{slugCategorie}/{slug}', 'Ludows\Adminify\Http\Controllers\Front\PostController@show')->name('posts.front.show');
