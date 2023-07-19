<?php

use Illuminate\Support\Facades\Route;

$c = config('site-settings.restApi');
$features = config('site-settings.enables_features');

if(!empty($c) && $c['enable']) {

    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    Route::post('/token/verify', '\Ludows\Adminify\Http\Controllers\Api\TokenController@verifyToken')->name('api.token.verify');
    Route::post('/token/refresh', '\Ludows\Adminify\Http\Controllers\Api\TokenController@refreshToken')->name('api.token.refresh');

    // Route::prefix($c['prefix'])->group( function () use ($c, $features) {

        Route::group(['middleware' => 'auth:api'], function() use ($c, $features) {
                if(isset($features['post']) && $features['post']) {
                    Route::resource('posts', 'App\Adminify\Http\Controllers\Api\PostController', [
                        'as' => $c['prefix'],
                        'except' => ['show']] )->middleware(['api.verify_token', 'api.verify_abilities']);
                }
        
                if(isset($features['media']) && $features['media']) {
                    Route::resource('medias', 'App\Adminify\Http\Controllers\Api\MediaController', [
                        'as' => $c['prefix'],
                        'except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities']);
                }
        
                if(isset($features['category']) && $features['category']) {
                    Route::resource('categories', 'App\Adminify\Http\Controllers\Api\CategoryController', [
                        'as' => $c['prefix'],
                        'except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities']);
                }
        
                if(isset($features['page']) &&  $features['page']) {
                    Route::resource('pages', 'App\Adminify\Http\Controllers\Api\PageController', [
                        'as' => $c['prefix'],
                        'except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities']);
                }
        
                if(isset($features['menu']) && $features['menu']) {
        
                }
        
                if(isset($features['comment']) && $features['comment']) {
                    Route::resource('comments', 'App\Adminify\Http\Controllers\Api\CommentController', [
                        'as' => $c['prefix'],
                        'except' => ['show' ]])->middleware(['api.verify_token', 'api.verify_abilities']);
                }
        
                if(isset($features['setting']) && $features['setting']) {
        
                }
        
                if(isset($features['key_translation']) && $features['key_translation']) {
                    Route::resource('traductions', 'App\Adminify\Http\Controllers\Api\TranslationsController', [
                        'as' => $c['prefix'],
                        'except' => ['show']])->middleware(['api.verify_token', 'api.verify_abilities']);
                }
    
            // });
        
        
            //$config crud
            if(count($c['crud']) > 0) {
                foreach ($c['crud'] as $key => $classValue) {
                    # code...
                    Route::resource($key, $classValue, [
                        'as' => $c['prefix'],
                    ])->middleware(['api.verify_token', 'api.verify_abilities']);
        
                }
            }
            if(count($c['customRoutes']) > 0) {
                $iterator_custom_routes = 0;
                foreach ($c['customRoutes'] as $arrayValues) {
                    # code...
                    foreach ($arrayValues['verbs'] as $verb) {
                        # code...
                        Route::{$verb}($arrayValues['route'], $arrayValues['controller'])->name('api.custom_route_'.$iterator_custom_routes)->middleware(['api.verify_token', 'api.verify_abilities']);
                    }
                    $iterator_custom_routes++;
                }
            }
        });

    $path_admin_file = base_path('routes/adminify_api.php');

    if(file_exists($path_admin_file)){
        include($path_admin_file);
    }
}
