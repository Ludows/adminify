<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.enables_features');
$themeManager = theme_manager();

// Route::prefix('admin')->middleware(['auth', 'multilang.basic', 'role:administrator|editor|subscriber', 'admin.breadcrumb', 'admin.menu', 'check.permissions', 'admin.deletemedia', 'admin.fullmode', 'admin.seo'])->group( function () use ($c, $themeManager) {

//     Route::get('/dashboard', 'App\Adminify\Http\Controllers\Back\HomeController@index')->name('home.dashboard');

//     Route::post('/search', 'App\Adminify\Http\Controllers\Back\SearchController@index')->name('searchable');

//     if(isset($c['post']) && $c['post']) {
// 	    Route::resource('posts', 'App\Adminify\Http\Controllers\Back\PostController', ['except' => ['show']] );
//     }

//     if(isset($c['media']) && $c['media']) {
//         // Route::resource('medias', 'App\Adminify\Http\Controllers\Back\MediaController', ['except' => ['show']]);
//         Route::resource('medias', 'App\Adminify\Http\Controllers\Back\Mediav2Controller', ['except' => ['show', 'edit']]);
//         Route::post('medias/upload', 'App\Adminify\Http\Controllers\Back\Mediav2Controller@upload')->name('medias.upload');
//         Route::post('medias/listing', 'App\Adminify\Http\Controllers\Back\Mediav2Controller@listing')->name('medias.listing');
//     }

//     if(isset($c['category']) && $c['category']) {
//         Route::resource('categories', 'App\Adminify\Http\Controllers\Back\CategoryController', ['except' => ['show']]);
//     }

//     if(isset($c['page']) &&  $c['page']) {
//         Route::resource('pages', 'App\Adminify\Http\Controllers\Back\PageController', ['except' => ['show']]);
//     }

//     if(isset($c['menu']) && $c['menu']) {
//         Route::resource('menus', 'App\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
//         Route::post('menus/set-items-to-menu/{id}/{type}', 'App\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
//         Route::post('menus/remove-items-to-menu/{id}', 'App\Adminify\Http\Controllers\Back\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
//         Route::post('menus/check-entity/{id}/{type}', 'App\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
//     }


//     if(isset($c['templates_content']) && $c['templates_content']) {
//         Route::resource('templates', 'App\Adminify\Http\Controllers\Back\TemplatesController', ['except' => ['show']]);
//         Route::post('templates/content', 'App\Adminify\Http\Controllers\Back\TemplatesController@setContent')->name('templates.setcontent');
//     }

//     Route::post('listings', 'App\Adminify\Http\Controllers\Back\ListingController@index')->name('listings');

//     if(isset($c['comment']) && $c['comment']) {
//         Route::resource('comments', 'App\Adminify\Http\Controllers\Back\CommentController', ['except' => ['show' ]]);
//     }

//     if(isset($c['setting']) && $c['setting']) {
//         Route::resource('settings', 'App\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
//     }
//     if(isset($c['user']) && $c['user']) {
//         Route::resource('users', 'App\Adminify\Http\Controllers\Back\UserController', ['except' => ['show']]);

//         Route::get('users/{user}/profile/', 'App\Adminify\Http\Controllers\Back\UserController@showProfile')->name('users.profile.edit');

//         Route::post('users/{user}/profile/save', 'App\Adminify\Http\Controllers\Back\UserController@saveProfile')->name('users.profile.store');
//     }

//     if(isset($c['key_translation']) && $c['key_translation']) {
//         Route::resource('traductions', 'App\Adminify\Http\Controllers\Back\TranslationsController', ['except' => ['show']]);
//     }

//     if(isset($c['tag']) && $c['tag']) {
//         Route::resource('tags', 'App\Adminify\Http\Controllers\Back\TagsController', ['except' => ['show']]);
//     }
//     // if(isset($c['email']) && $c['email']) {
//     //     Route::resource('mails', 'App\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

//     //     Route::post('mails/send/{mail}', 'App\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
//     // }

//     if(is_multilang()) {
//         Route::get('savetraductions', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController@edit')->name('savetraductions.edit');
//         Route::get('savetraductions/update', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController@update')->name('savetraductions.update');
//         // Route::resource('savetraductions', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController', ['except' => ['show', 'create', 'store', 'index', 'destroy']]);
//     }

//     // if(isset($c['post']) && $c['post']) {
//     // }

//     Route::post('editor/preview/{type}/{id?}', 'App\Adminify\Http\Controllers\Back\EditorController@preview')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('editor.preview');

//     Route::post('find/{type}', 'App\Adminify\Http\Controllers\Back\FinderController@index')->name('finder');

//     if(isset($c['seo']) && $c['seo']) {

//         Route::get('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@edit')->name('seo.edit');

//         Route::put('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');
//         Route::patch('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');

//     }

//     if(isset($c['form']) && $c['form']) {
//         // Route::resource('forms', 'App\Adminify\Http\Controllers\Back\FormsController', ['except' => ['show']]);

//         Route::get('/traces', 'App\Adminify\Http\Controllers\Back\FormsController@getTraces')->name('forms.traces.index');
//         Route::get('/traces/{trace}', 'App\Adminify\Http\Controllers\Back\FormsController@getTrace')->name('forms.traces.show');
//         Route::delete('/traces/destroy/{trace}', 'App\Adminify\Http\Controllers\Back\FormsController@destroyTrace')->name('forms.traces.destroy');

//     }

//     if(isset($c['metas']) && $c['metas']) {
//         Route::resource('groupmetas', 'App\Adminify\Http\Controllers\Back\GroupMetasController', ['except' => ['show']]);
//     }

//     if(isset($c['pwa']) && $c['pwa']) {
//         Route::resource('pwa', 'App\Adminify\Http\Controllers\Back\PwaController', ['except' => ['show', 'update', 'delete', 'edit']]);
//     }

//     Route::post('/forms/ajax/', 'App\Adminify\Http\Controllers\Back\HomeController@getForms')->name('forms.ajax');
//     Route::post('/content/', 'App\Adminify\Http\Controllers\Back\HomeController@getContents')->name('content.ajax');
//     Route::post('{type}/trash/{id}', 'App\Adminify\Http\Controllers\Back\TrashController@index')->name('trash');
//     Route::post('/{type}/duplicate/{id}', 'App\Adminify\Http\Controllers\Back\CopyController@index')->name('copy.entity');


//     // if(isset($c['media']) && $c['media']) {
//     //     Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     //         \UniSharp\LaravelFilemanager\Lfm::routes();
//     //     });
//     // }

//     // $path_admin_file = base_path('routes/adminify_admin.php');

//     // if(file_exists($path_admin_file)){
//     //     include($path_admin_file);
//     // }

//     if(is_installed()) {
//         $fileRoutes_in_themes = $themeManager->getFileRoutes('admin');
//         include($fileRoutes_in_themes);
//     }
// });

Route::prefix('admin')->middleware(['auth', 'role:administrator|editor|subscriber'])->group( function () use ($c, $themeManager) {
    Route::get('/dashboard', 'Ludows\Adminify\Http\Controllers\Back\V2\HomeController@index')->name('home.dashboard');
    
    Route::post('/search', 'Ludows\Adminify\Http\Controllers\Back\V2\SearchController@index')->name('searchable');

    if(isset($c['post']) && $c['post']) {
	    Route::resource('posts', 'Ludows\Adminify\Http\Controllers\Back\V2\PostController', ['except' => ['show']] );
    }

    if(isset($c['media']) && $c['media']) {
        // Route::resource('medias', 'App\Adminify\Http\Controllers\Back\MediaController', ['except' => ['show']]);
        Route::resource('medias', 'Ludows\Adminify\Http\Controllers\Back\V2\Mediav2Controller', ['except' => ['show', 'edit']]);
        Route::post('medias/upload', 'Ludows\Adminify\Http\Controllers\Back\V2\Mediav2Controller@upload')->name('medias.upload');
        Route::post('medias/listing', 'Ludows\Adminify\Http\Controllers\Back\V2\Mediav2Controller@listing')->name('medias.listing');
    }

    if(isset($c['category']) && $c['category']) {
        Route::resource('categories', 'Ludows\Adminify\Http\Controllers\Back\V2\CategoryController', ['except' => ['show']]);
    }

    if(isset($c['page']) &&  $c['page']) {
        Route::resource('pages', 'Ludows\Adminify\Http\Controllers\Back\V2\PageController', ['except' => ['show']]);
    }

    if(isset($c['menu']) && $c['menu']) {
        Route::resource('menus', 'Ludows\Adminify\Http\Controllers\Back\V2\MenuController', ['except' => ['show']]);
        Route::post('menus/set-items-to-menu/{type}', 'Ludows\Adminify\Http\Controllers\Back\V2\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
        Route::post('menus/remove-items-to-menu/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
        Route::post('menus/check-entity/{id}/{type}', 'Ludows\Adminify\Http\Controllers\Back\V2\MenuController@checkEntity')->name('menus.checkEntity');
    }


    if(isset($c['templates_content']) && $c['templates_content']) {
        Route::resource('templates', 'Ludows\Adminify\Http\Controllers\Back\V2\TemplatesController', ['except' => ['show']]);
        Route::post('templates/content', 'Ludows\Adminify\Http\Controllers\Back\V2\TemplatesController@setContent')->name('templates.setcontent');
    }

    Route::post('listings', 'Ludows\Adminify\Http\Controllers\Back\V2\ListingController@index')->name('listings');

    if(isset($c['comment']) && $c['comment']) {
        Route::resource('comments', 'Ludows\Adminify\Http\Controllers\Back\V2\CommentController', ['except' => ['show' ]]);
    }

    if(isset($c['setting']) && $c['setting']) {
        Route::resource('settings', 'Ludows\Adminify\Http\Controllers\Back\V2\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }
    if(isset($c['user']) && $c['user']) {
        Route::resource('users', 'Ludows\Adminify\Http\Controllers\Back\V2\UserController', ['except' => ['show']]);

        Route::get('users/{user}/profile/', 'Ludows\Adminify\Http\Controllers\Back\V2\UserController@showProfile')->name('users.profile.edit');

        Route::post('users/{user}/profile/save', 'Ludows\Adminify\Http\Controllers\Back\V2\UserController@saveProfile')->name('users.profile.store');
    }

    if(isset($c['key_translation']) && $c['key_translation']) {
        Route::resource('traductions', 'Ludows\Adminify\Http\Controllers\Back\V2\TranslationsController', ['except' => ['show']]);
    }

    if(isset($c['tag']) && $c['tag']) {
        Route::resource('tags', 'Ludows\Adminify\Http\Controllers\Back\V2\TagsController', ['except' => ['show']]);
    }
    // if(isset($c['email']) && $c['email']) {
    //     Route::resource('mails', 'App\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

    //     Route::post('mails/send/{mail}', 'App\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
    // }

    if(is_multilang()) {
        Route::get('savetraductions', 'Ludows\Adminify\Http\Controllers\Back\V2\SaveTranslationsController@edit')->name('savetraductions.edit');
        Route::get('savetraductions/update', 'Ludows\Adminify\Http\Controllers\Back\V2\SaveTranslationsController@update')->name('savetraductions.update');
        // Route::resource('savetraductions', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController', ['except' => ['show', 'create', 'store', 'index', 'destroy']]);
    }

    // if(isset($c['post']) && $c['post']) {
    // }

    Route::post('editor/preview/{type}/{id?}', 'Ludows\Adminify\Http\Controllers\Back\V2\EditorController@preview')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('editor.preview');

    Route::post('find/{type}', 'Ludows\Adminify\Http\Controllers\Back\V2\FinderController@index')->name('finder');

    if(isset($c['seo']) && $c['seo']) {

        Route::get('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\SeoController@edit')->name('seo.edit');

        Route::put('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\SeoController@update')->name('seo.update');
        Route::patch('seo/{type}/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\SeoController@update')->name('seo.update');

    }

    if(isset($c['form']) && $c['form']) {
        // Route::resource('forms', 'App\Adminify\Http\Controllers\Back\FormsController', ['except' => ['show']]);

        Route::get('/traces', 'Ludows\Adminify\Http\Controllers\Back\V2\FormsController@getTraces')->name('forms.traces.index');
        Route::get('/traces/{trace}', 'Ludows\Adminify\Http\Controllers\Back\V2\FormsController@getTrace')->name('forms.traces.show');
        Route::delete('/traces/destroy/{trace}', 'Ludows\Adminify\Http\Controllers\Back\V2\FormsController@destroyTrace')->name('forms.traces.destroy');

    }

    if(isset($c['metas']) && $c['metas']) {
        Route::resource('groupmetas', 'Ludows\Adminify\Http\Controllers\Back\V2\GroupMetasController', ['except' => ['show']]);
    }

    if(isset($c['pwa']) && $c['pwa']) {
        Route::resource('pwa', 'Ludows\Adminify\Http\Controllers\Back\V2\PwaController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }

    Route::post('/forms/ajax/', 'Ludows\Adminify\Http\Controllers\Back\V2\HomeController@getForms')->name('forms.ajax');
    Route::post('/content/', 'Ludows\Adminify\Http\Controllers\Back\V2\HomeController@getContents')->name('content.ajax');
    Route::post('{type}/trash/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\TrashController@index')->name('trash');
    Route::post('/{type}/duplicate/{id}', 'Ludows\Adminify\Http\Controllers\Back\V2\CopyController@index')->name('copy.entity');


    // if(isset($c['media']) && $c['media']) {
    //     Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    //         \UniSharp\LaravelFilemanager\Lfm::routes();
    //     });
    // }

    // $path_admin_file = base_path('routes/adminify_admin.php');

    // if(file_exists($path_admin_file)){
    //     include($path_admin_file);
    // }

    if(is_installed()) {
        $fileRoutes_in_themes = $themeManager->getFileRoutes('admin');
        include($fileRoutes_in_themes);
    }
});
