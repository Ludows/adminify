<?php
use Illuminate\Support\Facades\Route;

$c = config('site-settings.enables_features');
$themeManager = theme_manager();

Route::prefix('admin')->middleware(['auth', 'multilang.basic', 'role:administrator|editor|subscriber', 'admin.breadcrumb', 'admin.menu', 'check.permissions', 'admin.deletemedia', 'admin.fullmode', 'admin.seo'])->group( function () use ($c, $themeManager) {

    Route::get('/dashboard', 'App\Adminify\Http\Controllers\Back\HomeController@index')->name('home.dashboard');

    Route::post('/search', 'App\Adminify\Http\Controllers\Back\SearchController@index')->name('searchable');

    if(isset($c['post']) && $c['post']) {
	    Route::resource('posts', 'App\Adminify\Http\Controllers\Back\PostController', ['except' => ['show']] );
    }

    if(isset($c['media']) && $c['media']) {
        // Route::resource('medias', 'App\Adminify\Http\Controllers\Back\MediaController', ['except' => ['show']]);
        Route::resource('medias', 'App\Adminify\Http\Controllers\Back\Mediav2Controller', ['except' => ['show']]);
        Route::post('medias/upload', 'App\Adminify\Http\Controllers\Back\Mediav2Controller@upload')->name('medias.upload');
        Route::post('medias/listing', 'App\Adminify\Http\Controllers\Back\Mediav2Controller@listing')->name('medias.listing');
    }

    if(isset($c['category']) && $c['category']) {
        Route::resource('categories', 'App\Adminify\Http\Controllers\Back\CategoryController', ['except' => ['show']]);
    }

    if(isset($c['page']) &&  $c['page']) {
        Route::resource('pages', 'App\Adminify\Http\Controllers\Back\PageController', ['except' => ['show']]);
    }

    if(isset($c['menu']) && $c['menu']) {
        Route::resource('menus', 'App\Adminify\Http\Controllers\Back\MenuController', ['except' => ['show']]);
        Route::post('menus/set-items-to-menu/{id}/{type}', 'App\Adminify\Http\Controllers\Back\MenuController@setItemsToMenu')->name('menus.setItemsToMenu');
        Route::post('menus/remove-items-to-menu/{id}', 'App\Adminify\Http\Controllers\Back\MenuController@removeItemsToMenu')->name('menus.removeItemsToMenu');
        Route::post('menus/check-entity/{id}/{type}', 'App\Adminify\Http\Controllers\Back\MenuController@checkEntity')->name('menus.checkEntity');
    }


    if(isset($c['templates_content']) && $c['templates_content']) {
        Route::resource('templates', 'App\Adminify\Http\Controllers\Back\TemplatesController', ['except' => ['show']]);
        Route::post('templates/content', 'App\Adminify\Http\Controllers\Back\TemplatesController@setContent')->name('templates.setcontent');
    }

    Route::post('listings', 'App\Adminify\Http\Controllers\Back\ListingController@index')->name('listings');

    if(isset($c['comment']) && $c['comment']) {
        Route::resource('comments', 'App\Adminify\Http\Controllers\Back\CommentController', ['except' => ['show' ]]);
    }

    if(isset($c['setting']) && $c['setting']) {
        Route::resource('settings', 'App\Adminify\Http\Controllers\Back\SettingsController', ['except' => ['show', 'update', 'delete', 'edit']]);
    }
    if(isset($c['user']) && $c['user']) {
        Route::resource('users', 'App\Adminify\Http\Controllers\Back\UserController', ['except' => ['show']]);

        Route::get('users/{user}/profile/', 'App\Adminify\Http\Controllers\Back\UserController@showProfile')->name('users.profile.edit');

        Route::post('users/{user}/profile/save', 'App\Adminify\Http\Controllers\Back\UserController@saveProfile')->name('users.profile.store');
    }

    if(isset($c['key_translation']) && $c['key_translation']) {
        Route::resource('traductions', 'App\Adminify\Http\Controllers\Back\TranslationsController', ['except' => ['show']]);
    }

    if(isset($c['tag']) && $c['tag']) {
        Route::resource('tags', 'App\Adminify\Http\Controllers\Back\TagsController', ['except' => ['show']]);
    }
    // if(isset($c['email']) && $c['email']) {
    //     Route::resource('mails', 'App\Adminify\Http\Controllers\Back\MailsController', ['except' => ['show']]);

    //     Route::post('mails/send/{mail}', 'App\Adminify\Http\Controllers\Back\MailsController@send')->name('mails.send');
    // }

    if(is_multilang()) {
        Route::get('savetraductions', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController@edit')->name('savetraductions.edit');
        Route::get('savetraductions/update', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController@update')->name('savetraductions.update');
        // Route::resource('savetraductions', 'App\Adminify\Http\Controllers\Back\SaveTranslationsController', ['except' => ['show', 'create', 'store', 'index', 'destroy']]);
    }

    // if(isset($c['post']) && $c['post']) {
    // }

    Route::post('editor/preview/{type}/{id?}', 'App\Adminify\Http\Controllers\Back\EditorController@preview')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])->name('editor.preview');

    Route::post('find/{type}', 'App\Adminify\Http\Controllers\Back\FinderController@index')->name('finder');

    if(isset($c['seo']) && $c['seo']) {

        Route::get('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@edit')->name('seo.edit');

        Route::put('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');
        Route::patch('seo/{type}/{id}', 'App\Adminify\Http\Controllers\Back\SeoController@update')->name('seo.update');

    }

    if(isset($c['form']) && $c['form']) {
        // Route::resource('forms', 'App\Adminify\Http\Controllers\Back\FormsController', ['except' => ['show']]);

        Route::get('/traces', 'App\Adminify\Http\Controllers\Back\FormsController@getTraces')->name('forms.traces.index');
        Route::get('/traces/{trace}', 'App\Adminify\Http\Controllers\Back\FormsController@getTrace')->name('forms.traces.show');
        Route::delete('/traces/destroy/{trace}', 'App\Adminify\Http\Controllers\Back\FormsController@destroyTrace')->name('forms.traces.destroy');

    }

    if(isset($c['metas']) && $c['metas']) {
        Route::resource('groupmetas', 'App\Adminify\Http\Controllers\Back\GroupMetasController', ['except' => ['show']]);
    }

    Route::post('/forms/ajax/', 'App\Adminify\Http\Controllers\Back\HomeController@getForms')->name('forms.ajax');
    Route::post('/content/', 'App\Adminify\Http\Controllers\Back\HomeController@getContents')->name('content.ajax');
    Route::post('{type}/trash/{id}', 'App\Adminify\Http\Controllers\Back\TrashController@index')->name('trash');
    Route::post('/{type}/duplicate/{id}', 'App\Adminify\Http\Controllers\Back\CopyController@index')->name('copy.entity');


    if(isset($c['media']) && $c['media']) {
        Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });
    }

    // $path_admin_file = base_path('routes/adminify_admin.php');

    // if(file_exists($path_admin_file)){
    //     include($path_admin_file);
    // }

    if(is_installed()) {
        $fileRoutes_in_themes = $themeManager->getFileRoutes('admin');
        include($fileRoutes_in_themes);
    }
});
