<?php

use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');

if(isset($c) && $c['enable']) {
    
    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    Route::post('/token/verify', '\Ludows\Adminify\Http\Controllers\Api\TokenController@verifyToken')->name('api.token.verify');
    Route::post('/token/refresh', '\Ludows\Adminify\Http\Controllers\Api\TokenController@refreshToken')->name('api.token.refresh');

    if(isset($c['post']) && $c['post']) {	
	    Route::resource('posts', 'App\Adminify\Http\Controllers\Api\PostController', ['except' => ['show']] )->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.posts');
    }
    
    if(isset($c['media']) && $c['media']) {
        Route::resource('medias', 'App\Adminify\Http\Controllers\Api\MediaController', ['except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.medias');
    }
	
    if(isset($c['category']) && $c['category']) {
        Route::resource('categories', 'App\Adminify\Http\Controllers\Api\CategoryController', ['except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.categories');
    }

    if(isset($c['page']) &&  $c['page']) {	
        Route::resource('pages', 'Api\Adminify\Http\Controllers\Api\PageController', ['except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.pages');
    }
    
    if(isset($c['menu']) && $c['menu']) {
        // Route::resource('menus', 'Ludows\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
        // Route::post('menus/set-items-to-menu/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
        // Route::post('menus/remove-items-to-menu/{id}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
        // Route::post('menus/check-entity/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
    }

    if(isset($c['comment']) && $c['comment']) {
        Route::resource('comments', 'App\Adminify\Http\Controllers\Api\CommentController', ['except' => ['show' ]])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.comments');
    }

    if(isset($c['setting']) && $c['setting']) {
        // Route::resource('settings', 'Ludows\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }

    if(isset($c['key_translation']) && $c['key_translation']) {
        Route::resource('traductions', 'App\Adminify\Http\Controllers\Api\TranslationsController', ['except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.translations');
    }

    if(isset($c['email']) && $c['email']) {
        // Route::resource('mails', 'Ludows\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

        // Route::post('mails/send/{mail}', 'Ludows\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
    }

    if(isset($c['form']) && $c['form']) {
        // Route::resource('forms', 'Ludows\Adminify\Http\Controllers\Back\FormsController', ['except' => ['show']]);
    }
    //$config crud
    if(count($c['crud']) > 0) {
        foreach ($c['crud'] as $key => $classValue) {
            # code...
            Route::resource($key, $classValue, [
                'as' => $c['prefix'],
            ])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic']);

        }
    }
    if(count($c['customRoutes']) > 0) {
        $iterator_custom_routes = 0;
        foreach ($c['customRoutes'] as $arrayValues) {
            # code...
            foreach ($arrayValues['verbs'] as $verb) {
                # code...
                Route::{$verb}($arrayValues['route'], $arrayValues['controller'])->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->name('api.custom_route_'.$iterator_custom_routes);
            }
            $iterator_custom_routes++;
        }
    }

    $path_admin_file = base_path('routes/adminify_api.php');

    if(file_exists($path_admin_file)){
        include($path_admin_file);
    }
}
