<?php

use Illuminate\Support\Facades\Route;

$config = config('site-settings.restApi');

if(isset($config) && $config['enable']) {
    
    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    Route::post('/token/verify', '\Ludows\Adminify\Http\Controllers\Api\TokenController@verifyToken')->name('api.token.verify');
    Route::post('/token/refresh', '\Ludows\Adminify\Http\Controllers\Api\TokenController@refreshToken')->name('api.token.refresh');
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
