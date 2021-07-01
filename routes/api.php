<?php

use Illuminate\Support\Facades\Route;

$config = config('site-settings.restApi');

Route::get('/', '\Ludows\Adminify\Http\Controllers\Api\ListingController@index')->name('api.routelist');

if($config['enable']) {
    //$config crud
    if(count($config['crud']) > 0) {
        foreach ($config['crud'] as $key => $classValue) {
            # code...
            Route::resource($key, $classValue, [
                'as' => $config['prefix'],
            ]);

        }
    }
    if(count($config['customRoutes']) > 0) {
        foreach ($config['customRoutes'] as $arrayValues) {
            # code...
            foreach ($arrayValues['verbs'] as $verb) {
                # code...
                Route::{$verb}($arrayValues['route'], $arrayValues['controller']);
            }
        }
    }
}
