<?php

use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');

if(isset($c) && $c['enable']) {
    
    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    Route::post('/token/verify', '\Ludows\Adminify\Http\Controllers\Api\TokenController@verifyToken')->name('api.token.verify');
    Route::post('/token/refresh', '\Ludows\Adminify\Http\Controllers\Api\TokenController@refreshToken')->name('api.token.refresh');

    if(isset($c['post']) && $c['post']) {	
	    Route::resource('posts', 'App\Adminify\Http\Controllers\Api\PostController', ['except' => ['show']] );
    }
    
    if(isset($c['media']) && $c['media']) {
        Route::resource('medias', 'App\Adminify\Http\Controllers\Api\MediaController', ['except' => ['show']]);
    }
	
    if(isset($c['category']) && $c['category']) {
        Route::resource('categories', 'App\Adminify\Http\Controllers\Api\CategoryController', ['except' => ['show']]);
    }

    if(isset($c['page']) &&  $c['page']) {	
        Route::resource('pages', 'Api\Adminify\Http\Controllers\Api\PageController', ['except' => ['show']]);
    }
    
    if(isset($c['menu']) && $c['menu']) {
        // Route::resource('menus', 'Ludows\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
        // Route::post('menus/set-items-to-menu/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
        // Route::post('menus/remove-items-to-menu/{id}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
        // Route::post('menus/check-entity/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
    }

    
    if(isset($c['templates_content']) && $c['templates_content']) {
        // Route::resource('templates', 'Ludows\Adminify\Http\Controllers\Back\TemplatesController', ['except' => ['show']]);
        // Route::post('templates/content', 'Ludows\Adminify\Http\Controllers\Back\TemplatesController@setContent')->name('templates.setcontent');
    }

    if(isset($c['comment']) && $c['comment']) {
        Route::resource('comments', 'App\Adminify\Http\Controllers\Api\CommentController', ['except' => ['show' ]]);
    }

    if(isset($c['setting']) && $c['setting']) {
        // Route::resource('settings', 'Ludows\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }
    
    if(isset($c['user']) && $c['user']) {
        // Route::resource('users', 'Ludows\Adminify\Http\Controllers\Back\UserController', ['except' => ['show']]);

        // Route::get('users/{user}/profile/', 'Ludows\Adminify\Http\Controllers\Back\UserController@showProfile')->name('users.profile.edit');

        // Route::post('users/{user}/profile/save', 'Ludows\Adminify\Http\Controllers\Back\UserController@saveProfile')->name('users.profile.store');
    }

    if(isset($c['key_translation']) && $c['key_translation']) {
        Route::resource('traductions', 'App\Adminify\Http\Controllers\Api\TranslationsController', ['except' => ['show']]);
    }

    if(isset($c['tag']) && $c['tag']) {
        // Route::resource('tags', 'Ludows\Adminify\Http\Controllers\Back\TagsController', ['except' => ['show']]);
    }
    if(isset($c['email']) && $c['email']) {
        // Route::resource('mails', 'Ludows\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

        // Route::post('mails/send/{mail}', 'Ludows\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
    }

    if(is_multilang()) {
        // Route::resource('savetraductions', 'Ludows\Adminify\Http\Controllers\Back\SaveTranslationsController', ['except' => ['show', 'create', 'store', 'index', 'destroy']]);
    }

    if(isset($c['seo']) && $c['seo']) {	

        // Route::get('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@edit')->name('seo.edit');

        // Route::put('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');
        // Route::patch('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');

    }

    if(isset($c['form']) && $c['form']) {
        // Route::resource('forms', 'Ludows\Adminify\Http\Controllers\Back\FormsController', ['except' => ['show']]);
    }
    //$config crud
    if(count($config['crud']) > 0) {
        foreach ($config['crud'] as $key => $classValue) {
            # code...
            Route::resource($key, $classValue, [
                'as' => $config['prefix'],
            ])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic']);

        }
    }
    if(count($config['customRoutes']) > 0) {
        foreach ($config['customRoutes'] as $arrayValues) {
            # code...
            foreach ($arrayValues['verbs'] as $verb) {
                # code...
                Route::{$verb}($arrayValues['route'], $arrayValues['controller'])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic']);
            }
        }
    }

    $path_admin_file = base_path('routes/adminify_api.php');

    if(file_exists($path_admin_file)){
        include($path_admin_file);
    }
}
