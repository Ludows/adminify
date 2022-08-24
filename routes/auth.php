<?php

// Auth::routes();
use Illuminate\Support\Facades\Route;

$c = config('site-settings');

if(!empty($c)) {
    Route::middleware(['web', 'multilang.basic'])->group(function () use ($c) {
        // Authentication Routes...
        Route::get('login', 'App\Adminify\Http\Controllers\Auth\LoginController@showLoginForm')->name('auth.login');
        Route::post('login', 'App\Adminify\Http\Controllers\Auth\LoginController@login')->name('auth.login.post');
        Route::post('logout', 'App\Adminify\Http\Controllers\Auth\LoginController@logout')->name('auth.logout');
    
    
        if($c['enable_registration']) {
            // Registration Routes...
            Route::get('register', 'App\Adminify\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('auth.register');
            Route::post('register', 'App\Adminify\Http\Controllers\Auth\RegisterController@register')->name('auth.register.post');
        }
    
        // Password Reset Routes...
        Route::get('password/reset', 'App\Adminify\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.request');
        Route::post('password/email', 'App\Adminify\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.email');
        Route::get('password/reset/{token}', 'App\Adminify\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('auth.password.reset');
        Route::post('password/reset', 'App\Adminify\Http\Controllers\Auth\ResetPasswordController@reset')->name('auth.password.update');
    
        // Confirm Password (added in v6.2)
        Route::get('password/confirm', 'App\Adminify\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('auth.password.confirm');
        Route::post('password/confirm', 'App\Adminify\Http\Controllers\Auth\ConfirmPasswordController@confirm');
    
        // Email Verification Routes...
        Route::get('email/verify', 'App\Adminify\Http\Controllers\Auth\VerificationController@show')->name('auth.verification.notice');
        Route::get('email/verify/{id}/{hash}', 'App\Adminify\Http\Controllers\Auth\VerificationController@verify')->name('auth.verification.verify'); // v6.x
        /* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
        Route::get('email/resend', 'App\Adminify\Http\Controllers\Auth\VerificationController@resend')->name('auth.verification.resend');
    });
}



