<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Auth::routes();

// Authentication Routes...
Route::get('login', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@login');
Route::post('logout', 'Ludows\Adminify\Http\Controllers\Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Ludows\Adminify\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Ludows\Adminify\Http\Controllers\Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Ludows\Adminify\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Ludows\Adminify\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Ludows\Adminify\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Ludows\Adminify\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

// Confirm Password (added in v6.2)
Route::get('password/confirm', 'Ludows\Adminify\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', 'Ludows\Adminify\Http\Controllers\Auth\ConfirmPasswordController@confirm');

// Email Verification Routes...
Route::get('email/verify', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify'); // v6.x
/* Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify'); // v5.x */
Route::get('email/resend', 'Ludows\Adminify\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');

// Route::match(['get', 'post'], 'register', function () {
//     return abort(403, 'Forbidden');
// })->name('register');
require_once('admin.php');

if(config('site-settings.multilang')) {
    require_once('multilang.php');
}
else {
    require_once('no-multilang.php');
}


