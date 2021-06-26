<?php
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'multilang.basic', 'admin.breadcrumb', 'admin.menu', 'autoload.forms', 'check.permissions', 'admin.deletemedia'])->group( function () {

    Route::get('/dashboard', 'Ludows\Adminify\Http\Controllers\Back\HomeController@index')->name('home.dashboard');
    
    Route::post('/search', 'Ludows\Adminify\Http\Controllers\Back\SearchController@index')->name('searchable');

	Route::resource('posts', 'Ludows\Adminify\Http\Controllers\Back\PostController', [] );
	
    Route::resource('medias', 'Ludows\Adminify\Http\Controllers\Back\MediaController', ['except' => ['show']]);
	
    Route::resource('categories', 'Ludows\Adminify\Http\Controllers\Back\CategoryController', ['except' => ['show']]);
	
    Route::resource('pages', 'Ludows\Adminify\Http\Controllers\Back\PageController', []);
    
    Route::resource('menus', 'Ludows\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
    Route::post('menus/set-items-to-menu/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
    Route::post('menus/check-entity/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
    
    Route::resource('comments', 'Ludows\Adminify\Http\Controllers\Back\CommentController', ['except' => ['show', 'create']]);
    
    Route::resource('settings', 'Ludows\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
	
    Route::resource('users', 'Ludows\Adminify\Http\Controllers\Back\UserController', ['except' => ['show']]);
	
    Route::resource('traductions', 'Ludows\Adminify\Http\Controllers\Back\TranslationsController', ['except' => ['show']]);
	

    Route::get('modales/content/{name}', function ($name) {
        $returnView = view("layouts.admin.modales.contents.".$name, [])->render();
        return response()->json([
            'html' => $returnView,
        ]);
    })->name('modale.content');

    Route::get('modales/{name}', function ($name) {
        $returnView = view("layouts.admin.modales.".$name, [])->render();
        return response()->json([
            'html' => $returnView,
        ]);
    })->name('modale.getModale');

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

});
