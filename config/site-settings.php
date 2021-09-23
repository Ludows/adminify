<?php

return [
    'multilang' => env('ENABLE_MULTILANG', 1), // this use Translatable. Please to verify your migration for correct working..
    'headless' => false, // turn off front routing if you want to separate your front or your back

    'default_role_on_registration' => 'subscriber',

    // you can your named config searchable.
    // You must extend the classic Model Adminify to have this feature.
    'searchable' => [
        'admin' => [
            'limit' => 5,
            'name' => 'query'
        ]
    ],

    'adminMenu' => [
        'register.page',
        'register.post',
        'register.category',
        'register.tag',
        'register.media',
        'register.menu',
        'register.comment',
        'register.setting',
        'register.traduction',
        'register.mail_template',
        'register.content_type_template',
        // 'register.statistics', @todo later
        'register.user'
    ],

    'hooks' => [
        'model:creating' => [
            \App\Hooks\OnCreatingHook::class
        ],
        'model:created' => [
            \App\Hooks\OnCreatedHook::class,
            \App\Hooks\ContentTypesHook::class
        ],
        'model:updating' => [
            \App\Hooks\OnUpdatingHook::class,
        ],
        'model:updated' => [
            \App\Hooks\OnUpdatedHook::class,
            \App\Hooks\ContentTypesHook::class
        ],
        'model:deleting' => [
            \App\Hooks\OnDeletingHook::class,
            \App\Hooks\ContentTypesHook::class
        ],
        'model:deleted' => [
            \App\Hooks\OnDeletedHook::class,
        ],
        'setting:created' => [
            \App\Hooks\HandleSettings::class,
        ],
        'setting:updated' => [
            \App\Hooks\HandleSettings::class,
        ]
    ],

    'sitemap' => [
        'pages' => 'register.page',
        'posts' => 'register.post',
    ],

    'feeds' => [
        'trad' => [
            'all' => 'All ##DATA##',
            'title' => "##DATA## Index",
            'description' => "##DATA## description"
        ],
        'hydrate' => [
            'pages',
            'posts'
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
                ['icon' => '', 'key_title' => 'admin.medias.index', 'key_url' => 'medias.create' ],
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

    'shortcodes' => [
    ],

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'page' => 'register.page',
            'post' => 'register.post',
            'custom' => 'register.custom_link'
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
        'email' => true,
        'seo' => true,
        'templates_content' => true,
        'user' => true
    ],
    
    'savetraductions' => [
        'models' => [
            'post' => 'register.post',
            'page' => 'register.page',
            'translation' => 'register.traduction',
            'category' => 'register.categoriy',
            'menu' => 'register.menu',
            'tag' => 'register.tag',
            'mailable' => 'register.mail_template'
        ],
    ],

    // all routes search are binded to singular route name.
    'tables' => [
        'limit' => env('LISTINGS_LIMIT', 5),
        'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
        'search' => [
            'media' => 'register.media',
            'post' => 'register.post',
            'user' => 'register.user',
            'menu' => 'register.user',
            'page' => 'register.page',
            'category' => 'register.category',
            'comment' => 'register.comment',
            'traduction' => 'register.traduction',
            'tag' => 'register.tag',
            'mail' => 'register.mail_template',
            'template' => 'register.content_type_template'
        ]
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
           'pages' => \Ludows\Adminify\Http\Controllers\Api\PageController::class,
           'comments' => \Ludows\Adminify\Http\Controllers\Api\CommentController::class,
           'posts' => \Ludows\Adminify\Http\Controllers\Api\PostController::class,
           'medias' => \Ludows\Adminify\Http\Controllers\Api\MediaController::class,
           'categories' => \Ludows\Adminify\Http\Controllers\Api\CategoryController::class,
           'translations' => \Ludows\Adminify\Http\Controllers\Api\TranslationsController::class,
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
        'home' => \Ludows\Adminify\Interfacable\DashboardManager::class
    ],

    // 'dashboard' => [
    //     \Ludows\Adminify\Interfacable\Blocks\PageCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\PostCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\CategoryCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\TranslationsCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\MediaCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\TagCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\MailCard::class,
    //     \Ludows\Adminify\Interfacable\Blocks\MenuCard::class,
    // ]
];
