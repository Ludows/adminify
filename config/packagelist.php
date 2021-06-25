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
                'providers' => [
                    Artesaos\SEOTools\Providers\SEOToolsServiceProvider::class,
                ],
                'middlewares' => [],
                'aliases' => [
                    'SEOMeta'       => Artesaos\SEOTools\Facades\SEOMeta::class,
                    'OpenGraph'     => Artesaos\SEOTools\Facades\OpenGraph::class,
                    'Twitter'       => Artesaos\SEOTools\Facades\TwitterCard::class,
                    'JsonLd'        => Artesaos\SEOTools\Facades\JsonLd::class,
                    'JsonLdMulti'   => Artesaos\SEOTools\Facades\JsonLdMulti::class,
                    // or
                    'SEO' => Artesaos\SEOTools\Facades\SEOTools::class,
                ]
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
                'providers' => [
                    Kris\LaravelFormBuilder\FormBuilderServiceProvider::class
                ],
                'middlewares' => [],
                'aliases' => [
                    'FormBuilder' => Kris\LaravelFormBuilder\Facades\FormBuilder::class,
                ]
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
                'providers' => [
                    Spatie\Menu\Laravel\MenuServiceProvider::class,
                ],
                'middlewares' => [],
                'aliases' => [
                    'SpatieMenuGenerator' => Spatie\Menu\Laravel\Facades\Menu::class,
                ]
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
                'providers' => [
                    Spatie\Permission\PermissionServiceProvider::class,
                ],
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
            'publish' => null,
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
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/lfm',
                'name' => 'lfm',
            ],
            'afterPublish' => [
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
            'afterPublish' => [],
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
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'ludoows/adminify',
            'publish' => (object) [
                'tag' => true,
                'sibling' => 'adminify-config'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [
                    'named' => [
                        'autoload.forms' => \Ludows\Adminify\Http\Middleware\RequiredForms::class,
                        'admin.menu' => \Ludows\Adminify\Http\Middleware\GenerateAdminMenu::class,
                        'check.permissions' => \Ludows\Adminify\Http\Middleware\checkUserPermissions::class,
                        'multilang.basic' => \Ludows\Adminify\Http\Middleware\MultilangBasic::class,
                        'admin.breadcrumb' => \Ludows\Adminify\Http\Middleware\AdminBreadcrumb::class,
                        'front.blogpage' => \Ludows\Adminify\Http\Middleware\checkBlogPage::class
                    ]
                ],
                'aliases' => [
                    'MyMenuBuilder' => \Ludows\Adminify\Libs\MenuBuilder::class,
                ]
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'zerospam/laravel-gettext',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [
                    'web' => [
                        \Xinax\LaravelGettext\Middleware\GettextMiddleware::class,
                    ],
                ],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/laravel-gettext',
                'name' => 'laravel-gettext',
            ],
            'afterPublish' => [],
        )
    );