<?php

use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$features = config('site-settings.enables_features');

if(isset($c) && $c['enable']) {
    
    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    Route::post('/token/verify', '\Ludows\Adminify\Http\Controllers\Api\TokenController@verifyToken')->name('api.token.verify');
    Route::post('/token/refresh', '\Ludows\Adminify\Http\Controllers\Api\TokenController@refreshToken')->name('api.token.refresh');

    Route::prefix('api')->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic'])->group( function () use ($c, $features) {
        if(isset($features['post']) && $features['post']) {	
            Route::resource('posts', 'App\Adminify\Http\Controllers\Api\PostController', ['except' => ['show']] )->name('api.posts')->middleware();
        }
        
        if(isset($features['media']) && $features['media']) {
            Route::resource('medias', 'App\Adminify\Http\Controllers\Api\MediaController', ['except' => ['show']])->name('api.medias');
        }
        
        if(isset($features['category']) && $features['category']) {
            Route::resource('categories', 'App\Adminify\Http\Controllers\Api\CategoryController', ['except' => ['show']])->name('api.categories');
        }
    
        if(isset($features['page']) &&  $features['page']) {	
            Route::resource('pages', 'Api\Adminify\Http\Controllers\Api\PageController', ['except' => ['show']])->name('api.pages');
        }
        
        if(isset($features['menu']) && $features['menu']) {
            
        }
    
        if(isset($features['comment']) && $features['comment']) {
            Route::resource('comments', 'App\Adminify\Http\Controllers\Api\CommentController', ['except' => ['show' ]])->name('api.comments');
        }
    
        if(isset($features['setting']) && $features['setting']) {

        }
    
        if(isset($features['key_translation']) && $features['key_translation']) {
            Route::resource('traductions', 'App\Adminify\Http\Controllers\Api\TranslationsController', ['except' => ['show']])->name('api.translations');
        }
    
        if(isset($features['email']) && $features['email']) {
    
        }
    
        if(isset($features['form']) && $features['form']) {

        }
    });

    
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
                Route::{$verb}($arrayValues['route'], $arrayValues['controller'])->name('api.custom_route_'.$iterator_custom_routes)->middleware(['api.verify_token', 'api.verify_abilities', 'multilang.basic']);
            }
            $iterator_custom_routes++;
        }
    }

    $path_admin_file = base_path('routes/adminify_api.php');

    if(file_exists($path_admin_file)){
        include($path_admin_file);
    }
}
