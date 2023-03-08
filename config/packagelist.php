<?php


return array(
        (object) array(
            'beforePublish' => [],
            'name' => 'artesaos/seotools',
            'publish' => (object) [
                'tag' => false,
                'force' => false,
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
                'force' => false,
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
            'name' => 'spatie/laravel-backup',
            'publish' => (object) [
                'tag' => false,
                'force' => false,
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
                'force' => false,
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
                'force' => false,
                'sibling' => 'Spatie\Permission\PermissionServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [
                    Spatie\Permission\PermissionServiceProvider::class,
                ],
                'middlewares' => [
                    'named' => [
                        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
                        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
                        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
                    ]
                ],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/permission',
                'name' => 'permission',
            ],
            'afterPublish' => [
                'php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"'
            ],
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
                'force' => false,
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
                'force' => false,
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
            'name' => 'ycs77/laravel-form-builder-bs4',
            'publish' => (object) [
                'tag' => true,
                'force' => false,
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
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [
                    'named' => [
                        'admin.menu' => \App\Adminify\Http\Middleware\GenerateAdminMenu::class,
                        'check.permissions' => \App\Adminify\Http\Middleware\CheckUserPermissions::class,
                        'multilang.basic' => \App\Adminify\Http\Middleware\MultilangBasic::class,
                        'admin.breadcrumb' => \App\Adminify\Http\Middleware\AdminBreadcrumb::class,
                        'front.blogpage' => \App\Adminify\Http\Middleware\CheckBlogPage::class,
                        'admin.deletemedia' => \App\Adminify\Http\Middleware\DeleteMedia::class,
                        'admin.fullmode' => \App\Adminify\Http\Middleware\DisplayFullmode::class,
                        'admin.seo' => \App\Adminify\Http\Middleware\BackendSeo::class,
                        'api.verify_token' => \App\Adminify\Http\Middleware\VerifyApiToken::class,
                        'api.verify_abilities' => \App\Adminify\Http\Middleware\VerifyAbilitiesToken::class
                    ],
                    'web' => [
                        \App\Adminify\Http\Middleware\ShareCurrentUser::class
                    ]
                ],
                'aliases' => [
                    'MyMenuBuilder' => \Ludows\Adminify\Libs\MenuBuilder::class,
                    'ToolBar' => Ludows\Adminify\Libs\AdminableToolbar::class
                ]
            ],
            'config' => null,
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'laravelium/sitemap',
            'publish' => (object) [
                'tag' => false,
                'force' => false,
                'sibling' => 'Laravelium\Sitemap\SitemapServiceProvider'
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
            'name' => 'spatie/laravel-feed',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [
                'php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="feed-config"',
                'php artisan vendor:publish --provider="Spatie\Feed\FeedServiceProvider" --tag="feed-views"'
            ],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'laravel-database-mail-templates',
            'publish' => null,
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
            'name' => 'stolz/assets',
            'publish' => null,
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => (object) [
                'file' => '/../../config/assets',
                'name' => 'assets',
            ],
            'afterPublish' => [],
        ),
        (object) array(
            'beforePublish' => [],
            'name' => 'league/glide-laravel',
            'publish' => null,
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
            'name' => 'snowfire/beautymail',
            'publish' => (object) [
                'tag' => false,
                'force' => false,
                'sibling' => 'Snowfire\Beautymail\BeautymailServiceProvider'
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
            'name' => 'anhskohbo/no-captcha',
            'publish' => (object) [
                'tag' => false,
                'force' => false,
                'sibling' => 'Anhskohbo\NoCaptcha\NoCaptchaServiceProvider'
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
            'name' => 'spatie/laravel-sitemap',
            'publish' => (object) [
                'tag' => 'sitemap-config',
                'force' => false,
                'sibling' => 'Spatie\Sitemap\SitemapServiceProvider'
            ],
            'autoload' => (object) [
                'providers' => [],
                'middlewares' => [],
                'aliases' => []
            ],
            'config' => null,
            'afterPublish' => [],
        ),
    );