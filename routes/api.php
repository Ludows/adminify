<?php

use Illuminate\Support\Facades\Route;

$config = config('site-settings.restApi');

if($config['enable']) {
    
    Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('routelist');
    Route::post('/token', '\Ludows\Adminify\Http\Controllers\Api\TokenController@getToken')->name('api.token');
    //$config crud
    if(count($config['crud']) > 0) {
        foreach ($config['crud'] as $key => $classValue) {
            # code...
            Route::resource($key, $classValue, [
                'as' => $config['prefix'],
            ])->middelware('api.verify');

        }
    }
    if(count($config['customRoutes']) > 0) {
        foreach ($config['customRoutes'] as $arrayValues) {
            # code...
            foreach ($arrayValues['verbs'] as $verb) {
                # code...
                Route::{$verb}($arrayValues['route'], $arrayValues['controller'])->middelware('api.verify');
            }
        }
    }
}
