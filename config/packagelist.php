<?php


return array(
        (object) array(
            'beforePublish' => [],
            'name' => 'artesaos/seotools',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Artesaos\SEOTools\Providers\SEOToolsServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/seotools',
                'name' => 'seotools',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'diglactic/laravel-breadcrumbs',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/breadcrumbs',
                'name' => 'breadcrumbs',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'kris/laravel-form-builder',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/laravel-form-builder',
                'name' => 'laravel-form-builder',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'laracasts/flash',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Laracasts\Flash\FlashServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'mratiebatie/laravel-repositories',
            'publish' => null,
            'config' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'nadar/quill-delta-parser',
            'publish' => null,
            'config' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'silviolleite/laravelpwa',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'LaravelPWA\Providers\LaravelPWAServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/laravel-backup',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Backup\BackupServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/backup',
                'name' => 'backup',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/laravel-menu',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Menu\Laravel\MenuServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/laravel-permission',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Permission\PermissionServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/permission',
                'name' => 'permission',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/laravel-searchable',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Permission\PermissionServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'publishes' => null,
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/laravel-translatable',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Translatable\TranslatableServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/translatable',
                'name' => 'translatable',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'spatie/menu',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'Spatie\Menu\Laravel\MenuServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'thunderer/shortcode',
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'publish' => null,
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'unisharp/laravel-filemanager',
            'publish' => null,
            'config' => (object) [
                'file' => '/../../config/lfm',
                'name' => 'lfm',
            ],
            'afterInstall' => [
                'php artisan vendor:publish --tag=lfm_config',
                'php artisan vendor:publish --tag=lfm_public',
                'php artisan storage:link'
            ],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'van-ons/laraberg',
            'publish' => (object) [
                'tag' => false,
                'sibling' => 'VanOns\Laraberg\LarabergServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/laraberg',
                'name' => 'laraberg',
            ],
            'afterInstall' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'ycs77/laravel-form-builder-bs4',
            'publish' => (object) [
                'tag' => true,
                'sibling' => 'laravel-form-builder-bs4'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterInstall' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'zerospam/laravel-gettext',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/laravel-gettext',
                'name' => 'laravel-gettext',
            ],
            'afterInstall' => [],
        )
    );