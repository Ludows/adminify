<?php

return [
    'multilang' => env('ENABLE_MULTILANG', 1), // this use Translatable. Please to verify your migration for correct working..
    'headless' => false, // turn off front routing if you want to separate your front or your back

    'enable_registration' => false,
    'default_role_on_registration' => 'subscriber',

    'custom_views_paths' => [
        'theme' => resource_path('theme'),
        'blocs' => resource_path('blocs')
    ],

    'themes' => [
        'root_path' => resource_path('theme')
    ],

    'blog' => [
        'paginate' => 10,
        'columns' => ['*'],
        'param' => 'page'
    ],

    'front' => [
        'handle' => \App\Adminify\Http\Controllers\Front\PageController::class,
        'file_routes' => 'front_end_routes.php',
        'appendTo' => base_path('routes/'),
        'methods' => [
            'homepage' => 'index',
            'pages' => 'getPages',
            'category' => 'getCategory',
            'categories' => 'getCategories',
            'tag' => 'getTag',
            'tags' => 'getTags',
            'archives' => 'getArchives'
        ]
    ],

    'media_library' => [
        'driver' => 'public',
        'paramName' => 'file',
        'thumbs' => [
            'w' => 200,
            'h' => 200
        ],
        'limit' => 30,
        'allow_rename' => false,
        'validator_rule' => 'required|max:204800',
        'allowed_mime_types' => [
            'image/jpeg',
            'image/pjpeg',
            'image/png',
            'image/gif',
            'application/pdf',
            'text/plain',
        ]
    ],

    // you can your named config searchable.
    // You must extend the classic Model Adminify to have this feature.
    'searchable' => [
        'admin' => [
            'limit' => 5,
            'name' => 'query'
        ],
        'front' => [
            'limit' => -1,
            'name' => 'query'
        ]
    ],

    'medias' => [
        'prefers_id_on' => ['media_id', 'logo_id', 'menu-three-key', 'avatar_id', 'avatar'],
    ],

    'assets' => array(
        'collections' => array(
            'core_backend' => array(
                adminify_asset('/adminify/vendor/nucleo/css/nucleo.css'),
                adminify_asset('/adminify/vendor/@fortawesome/fontawesome-free/css/all.min.css'),
                adminify_asset('/adminify/back/css/argon.css'),
                adminify_asset('/adminify/back/css/extensions.css'),
                adminify_asset('/myuploads/routes.js'),
                adminify_asset('/adminify/back/js/extensions.js'),
                adminify_asset('/myuploads/traductions-'. lang() .'.js'),
                adminify_asset('/adminify/back/js/extensions-call.js'),
                adminify_asset('/adminify/back/js/argon.js'),
                adminify_asset('/adminify/back/js/searchable.js'),
            ),
            'core_frontend' => array(
                adminify_asset('/myuploads/routes.js'),
                adminify_asset('/myuploads/traductions-'. lang() .'.js'),
            ),
            'backend' => array(
                'core_backend',
            ),
            'frontend' => array(
                'core_frontend'
            ),
        ),
        'autoload' => is_running_console() ? [] : (is_admin() ? array('backend') : array('frontend')),
    ),

    'metas' => [
        // excludes models here
        'excludesOn' => [
            'destroy',
            'store',
            'update',
            'lfm',
            'finder',
            'searchable',
            'listings',
            'ajax',
            'trash'
        ]
    ],

    // 'dynamic_forms' => [
    //     'default_form_template' => 'adminify::layouts.commons.forms.default',
    //     'show_form_when_validated' => true,
    //     'skip_autosend' => false, // for tests
    //     'default_email_user' => 'theartist768@gmail.com', // if your want to overwrite the default user. Specify form with his slug
    // ],

    'adminMenu' => [
        'Page',
        'Post',
        'Category',
        'Tag',
        'Media',
        'GroupMeta',
        'Menu',
        'Comment',
        'Settings',
        'Translations',
        'Templates',
        'User'
    ],

    'hooks' => [
        'creating' => [
            \App\Adminify\Hooks\OnCreatingHook::class
        ],
        'created' => [
            \App\Adminify\Hooks\OnCreatedHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class,
            \App\Adminify\Hooks\HandleSettings::class,
            \App\Adminify\Hooks\CreateCacheHook::class,
        ],
        'updating' => [
            \App\Adminify\Hooks\OnUpdatingHook::class,
        ],
        'updated' => [
            \App\Adminify\Hooks\OnUpdatedHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class,
            \App\Adminify\Hooks\HandleSettings::class,
            \App\Adminify\Hooks\CreateCacheHook::class,
        ],
        'deleting' => [
            \App\Adminify\Hooks\OnDeletingHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class
        ],
        'deleted' => [
            \App\Adminify\Hooks\OnDeletedHook::class,
            \App\Adminify\Hooks\ClearCacheHook::class,
        ],
        'mail:before_send' => [],
        'mail:after_send' => [],
        'after_form_page' => \App\Adminify\Hooks\RevisionShowHook::class
    ],

    'sitemap' => [
        'pages' => 'Page',
        'posts' => 'Post',
    ],

    'feeds' => [
        'trad' => [
            'all' => 'All ##DATA##',
            'title' => "##DATA## Index",
            'description' => "##DATA## description"
        ],
        'hydrate' => [
            'Page',
            'Post',
        ]
    ],


    // key_title is available for trads otherwise it's title
    // key_url is available for trads otherwise it's url
    // when you have to render dynamix urls , please to refers to dynamic_url
    // todo showIf as function closure
    // show
    'toolbar' => [
        'menu' => array(
            ['icon' => '', 'key_title' => 'admin.toolbar.dashboard', 'key_url' => 'home.dashboard' ],
            ['icon' => '', 'key_title' => 'admin.toolbar.new_comment', 'key_url' => 'comments.index', 'dynamic_show' => '\Ludows\Adminify\Libs\AdminableToolbar@newComment'],
            ['icon' => '', 'key_title' => 'admin.toolbar.create', 'paths' => [
                ['icon' => '', 'key_title' => 'admin.posts.index', 'key_url' => 'posts.create' ],
                ['icon' => '', 'key_title' => 'admin.pages.index', 'key_url' => 'pages.create'],
                ['icon' => '', 'key_title' => 'admin.menus.index', 'key_url' => 'menus.create' ],
                ['icon' => '', 'key_title' => 'admin.medias.index', 'key_url' => 'medias.index' ],
                ['icon' => '', 'key_title' => 'admin.traductions.index', 'key_url' => 'traductions.create' ],
                ['icon' => '', 'key_title' => 'admin.categories.index', 'key_url' => 'categories.create' ]
            ] ],
            ['icon' => '', 'key_title' => 'admin.toolbar.modify', 'dynamic_url' => '\Ludows\Adminify\Libs\AdminableToolbar@modify'],
            ['icon' => '', 'key_title' => 'admin.toolbar.user', 'paths' => [
                ['icon' => '', 'key_title' => 'admin.user.edit', 'dynamic_url' => '\Ludows\Adminify\Libs\AdminableToolbar@userEdit' ],
                ['icon' => '', 'key_title' => 'admin.user.profile', 'dynamic_url' => '\Ludows\Adminify\Libs\AdminableToolbar@userProfile'],
                ['icon' => '', 'key_title' => 'admin.logout', 'url' => '/logout'],
            ] ],
        ),
    ],

    'revisions' => [
        'escaped_keys' => ['id', 'slug']
    ],

    'shortcodes' => [
        'form' => \App\Adminify\Shortcodes\FormShortcode::class,
        'template' => \App\Adminify\Shortcodes\TemplateShortcode::class,
        'frontify-form' => \App\Adminify\Shortcodes\FrontifyFormShortcode::class,
    ],

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'page' => 'Page',
            'post' => 'Post',
            'custom' => 'CustomLink'
        ],
        'showAlways' => [
            'custom' => [ // you can pass some field to build your form
                'title' => ['type' => 'text', 'options' => []],
                'url' => ['type' => 'text', 'options' => []],
                'open_new_tab' => ['type' => 'checkbox', 'options' => []]
            ]
        ]
    ],

    'supported_locales' => [
        'en',
        'fr'
    ],

    'enables_features' => [
        'media' => true,
        'category' => true,
        'page' => true,
        'post' => true,
        'tag' => true,
        'comment' => true,
        'menu' => true,
        'setting' => true,
        'key_translation' => true,
        'seo' => true,
        'templates_content' => true,
        'user' => true,
        'form' => true,
        'metas' => true,
    ],

    // all routes search are binded to singular route name.
    'tables' => [
        'limit' => env('LISTINGS_LIMIT', 5),
        'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
    ],

    // this is possible for all website ( front and back )
    'restApi' => [
        'enable' => true, // resets to false to disable entierely rest api
        'prefix' => 'api', // use prefix
        'domain' => null, // to set a domain, just replace by your domain,
        'token_name' => 'api-token',
        'secret' => 'my-random-string',
        'expiration_time' => null, // if null this will never been expirated
        'token_capacities' => [ // for user roles based
            'administrator' => ['api:update', 'api:read', 'api:create', 'api:delete'],
            'editor' => ['api:update', 'api:read', 'api:create', 'api:delete'],
            'subscriber' => ['api:read'],
            'guest' => ['api:read']
        ],
        'crud' => [
            // controllers here we binded like the CRUD pattern
        //    'pages' => \App\Adminify\Http\Controllers\Api\PageController::class,
        //    'comments' => \App\Adminify\Http\Controllers\Api\CommentController::class,
        //    'posts' => \App\Adminify\Http\Controllers\Api\PostController::class,
        //    'medias' => \App\Adminify\Http\Controllers\Api\MediaController::class,
        //    'categories' => \App\Adminify\Http\Controllers\Api\CategoryController::class,
        //    'translations' => \App\Adminify\Http\Controllers\Api\TranslationsController::class,
        ],
        'customRoutes' => [
            // ex : [
            //     'route' => 'posts/getKeys',
            //     'verbs' => ['GET', 'POST'],
            //     'controller' => 'MyAwesomeClass@getKeys'
            //  ]
        ]
    ],

    'interfaces' => [
        'home' => \App\Adminify\Interfacable\DashboardManager::class,
        'formbuilder' => \App\Adminify\Interfacable\FormBuilderManager::class,
    ],
];
