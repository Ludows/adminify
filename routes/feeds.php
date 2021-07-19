<?php
use Illuminate\Support\Facades\Route;

Route::get('/feeds/{slug?}', 'Ludows\Adminify\Http\Controllers\Back\FeedsController@index')->name('feed.index');