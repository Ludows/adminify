<?php

// Auth::routes();
use Illuminate\Support\Facades\Route;

$c = config('site-settings');

if(!empty($c)) {
    Route::middleware(['web', 'multilang.basic'])->group(function () use ($c) {
        // Authentication Routes...
        Route::get('login', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@showLoginForm')->name('auth.login');
        Route::post('login', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@login')->name('auth.login.post');
        Route::post('logout', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');
    
    
        if($c['enable_registration']) {
            // Registration Routes...
            Route::get('register', 'Ludows\Adminify\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('auth.register');
            Route::post('register', 'Ludows\Adminify\Http\Controllers\Auth\RegisterController@register')->name('auth.register.post');
        }
    
        // Password Reset Routes...
        Route::get('password/reset', 'Ludows\Adminify\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.request');
        Route::post('password/email', 'Ludows\Adminify\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.email');
        Route::get('password/reset/{token}', 'Ludows\Adminify\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('auth.password.reset');
        Route::post('password/reset', 'Ludows\Adminify\Http\Controllers\Auth\ResetPasswordController@reset')->name('auth.password.update');
    
        // Confirm Password (added in v6.2)
        Route::get('password/confirm', 'Ludows\Adminify\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('auth.password.confirm');
        Route::post('password/confirm', 'Ludows\Adminify\Http\Controllers\Auth\ConfirmPasswordController@confirm');
    
        // Email Verification Routes...
        Route::get('email/verify', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@show')->name('auth.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@verify')->name('auth.verification.verify'); // v6.x
        /* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
        Route::get('email/resend', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@resend')->name('auth.verification.resend');
    });
}



