<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.enables_features');

Route::prefix('admin')->middleware(['auth', 'multilang.basic', 'role:administrator|editor', 'admin.breadcrumb', 'admin.menu', 'check.permissions', 'admin.deletemedia', 'admin.fullmode', 'admin.seo'])->group( function () use ($c) {

    Route::get('/dashboard', 'Ludows\Adminify\Http\Controllers\Back\HomeController@index')->name('home.dashboard');
    
    Route::post('/search', 'Ludows\Adminify\Http\Controllers\Back\SearchController@index')->name('searchable');

    if(isset($c['post']) && $c['post']) {	
	    Route::resource('posts', 'Ludows\Adminify\Http\Controllers\Back\PostController', ['except' => ['show']] );
    }
    
    if(isset($c['media']) && $c['media']) {
        Route::resource('medias', 'Ludows\Adminify\Http\Controllers\Back\MediaController', ['except' => ['show']]);
    }
	
    if(isset($c['category']) && $c['category']) {
        Route::resource('categories', 'Ludows\Adminify\Http\Controllers\Back\CategoryController', ['except' => ['show']]);
    }

    if(isset($c['page']) &&  $c['page']) {	
        Route::resource('pages', 'Ludows\Adminify\Http\Controllers\Back\PageController', ['except' => ['show']]);
    }
    
    if(isset($c['menu']) && $c['menu']) {
        Route::resource('menus', 'Ludows\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
        Route::post('menus/set-items-to-menu/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
        Route::post('menus/remove-items-to-menu/{id}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
        Route::post('menus/check-entity/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
    }

    
    if(isset($c['templates_content']) && $c['templates_content']) {
        Route::resource('templates', 'Ludows\Adminify\Http\Controllers\Back\TemplatesController', ['except' => ['show']]);
        Route::post('templates/content', 'Ludows\Adminify\Http\Controllers\Back\TemplatesController@setContent')->name('templates.setcontent');
    }

    Route::post('listings', 'Ludows\Adminify\Http\Controllers\Back\ListingController@index')->name('listings');

    if(isset($c['comment']) && $c['comment']) {
        Route::resource('comments', 'Ludows\Adminify\Http\Controllers\Back\CommentController', ['except' => ['show' ]]);
    }

    if(isset($c['setting']) && $c['setting']) {
        Route::resource('settings', 'Ludows\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }
    if(isset($c['user']) && $c['user']) {
        Route::resource('users', 'Ludows\Adminify\Http\Controllers\Back\UserController', ['except' => ['show']]);

        Route::get('users/{user}/profile/', 'Ludows\Adminify\Http\Controllers\Back\UserController@showProfile')->name('users.profile.edit');

        Route::post('users/{user}/profile/save', 'Ludows\Adminify\Http\Controllers\Back\UserController@saveProfile')->name('users.profile.store');
    }

    if(isset($c['key_translation']) && $c['key_translation']) {
        Route::resource('traductions', 'Ludows\Adminify\Http\Controllers\Back\TranslationsController', ['except' => ['show']]);
    }

    if(isset($c['tag']) && $c['tag']) {
        Route::resource('tags', 'Ludows\Adminify\Http\Controllers\Back\TagsController', ['except' => ['show']]);
    }
    if(isset($c['email']) && $c['email']) {
        Route::resource('mails', 'Ludows\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

        Route::post('mails/send/{mail}', 'Ludows\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
    }

    if(is_multilang()) {
        Route::resource('savetraductions', 'Ludows\Adminify\Http\Controllers\Back\SaveTranslationsController', ['except' => ['show', 'create', 'store', 'index', 'destroy']]);
    }

    // if(isset($c['post']) && $c['post']) {	
    // }

    Route::post('find/{type}', 'Ludows\Adminify\Http\Controllers\Back\FinderController@index')->name('finder');

    if(isset($c['seo']) && $c['seo']) {	

        Route::get('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@edit')->name('seo.edit');

        Route::put('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');
        Route::patch('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');

    }

    Route::post('/forms/', 'Ludows\Adminify\Http\Controllers\Back\HomeController@getForms')->name('forms.ajax');
    Route::post('/content/', 'Ludows\Adminify\Http\Controllers\Back\HomeController@getContents')->name('content.ajax');
    Route::post('{type}/trash/{id}', 'Ludows\Adminify\Http\Controllers\Back\TrashController@index')->name('trash');


    if(isset($c['media']) && $c['media']) {
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    }

    $path_admin_file = app_path('routes/adminify_admin.php');

    if(file_exists($path_admin_file)){
        include($path_admin_file);
    }


});
