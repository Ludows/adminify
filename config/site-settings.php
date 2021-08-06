<?php

return [
    'multilang' => env('ENABLE_MULTILANG', true), // this use Translatable. Please to verify your migration for correct working..
    'headless' => false, // turn off front routing if you want to separate your front or your back

    'register' => [
        'categories' => \App\Models\Category::class,
        'comments' => \App\Models\Comment::class,
        'custom_links' => \App\Models\CustomLink::class,
        'medias' => \App\Models\Media::class,
        'menus' => \App\Models\Menu::class,
        'menu_items' => \App\Models\MenuItem::class,
        'pages' => \App\Models\Page::class,
        'posts' => \App\Models\Post::class,
        'seo' => \App\Models\Seo::class,
        'settings' => \App\Models\Settings::class,
        'traductions' => \App\Models\Translations::class,
        'url' => \App\Models\Url::class,
        'users' => \App\Models\User::class,
        'tags' => \App\Models\Tag::class,
        'mailables' => \App\Models\Mailables::class,
        'statistics' => \App\Models\Statistics::class,
        'templates' => \App\Models\Templates::class
    ],

    'sitemap' => [
        'pages' => 'register.pages',
        'posts' => 'register.posts',
        'medias' => 'register.medias'
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
    // todo showIf as function closure
    'toolbar' => [
        'menu' => array(
            ['icon' => '', 'key_title' => 'admin.toolbar.dashboard', 'url' => route('admin.dashboard') ],
            ['icon' => '', 'key_title' => 'admin.toolbar.create', 'paths' => [
                ['icon' => '', 'key_title' => 'admin.posts.index', 'url' => route('posts.create') ],
                ['icon' => '', 'key_title' => 'admin.pages.index', 'url' => route('pages.create') ],
                ['icon' => '', 'key_title' => 'admin.menus.index', 'url' => route('menus.create') ],
                ['icon' => '', 'key_title' => 'admin.medias.index', 'url' => route('medias.create') ],
                ['icon' => '', 'key_title' => 'admin.traductions.index', 'url' => route('traductions.create') ],
                ['icon' => '', 'key_title' => 'admin.categories.index', 'url' => route('categories.create') ]
            ] ],
            ['icon' => '', 'key_title' => 'admin.toolbar.modify', 'url' => function() {
    
            } ],
        ),
    ],

    'shortcodes' => [
    ],

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'page' => 'register.pages',
            'post' => 'register.posts',
            'custom' => 'register.custom_links'
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

    // please to pay attention that your models implements Searchable.
    'searchable' => [
        'admin' => [
            'models' => [
                'posts' => 'register.posts',
                'users' => 'register.users',
                'menus' => 'register.menus',
                'pages' => 'register.pages',
                'tags' => 'register.tags',
                'traductions' => 'register.traductions'
            ],
            'limit' => 5,
            'name' => 'query'
        ]
    ],

    
    'savetraductions' => [
        'models' => [
            'post' => 'register.posts',
            'page' => 'register.pages',
            'translation' => 'register.traductions',
            'category' => 'register.categories',
            'menu' => 'register.menus',
            'tag' => 'register.tags',
            'mailable' => 'register.mailable'
        ],
    ],

    // all routes search are binded to singular route name.
    'listings' => [
        'limit' => env('LISTINGS_LIMIT', 5),
        'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
        'search' => [
            'media' => 'register.medias',
            'post' => 'register.posts',
            'user' => 'register.users',
            'menu' => 'register.users',
            'page' => 'register.pages',
            'category' => 'register.categories',
            'comment' => 'register.comments',
            'traduction' => 'register.traductions',
            'tag' => 'register.tags',
            'mail' => 'register.mailable',
            'template' => 'register.templates'
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

    'dashboard' => [
        \Ludows\Adminify\Interfacable\Blocks\PageCard::class,
        \Ludows\Adminify\Interfacable\Blocks\PostCard::class,
        \Ludows\Adminify\Interfacable\Blocks\CategoryCard::class,
        \Ludows\Adminify\Interfacable\Blocks\TranslationsCard::class,
        \Ludows\Adminify\Interfacable\Blocks\MediaCard::class,
        \Ludows\Adminify\Interfacable\Blocks\TagCard::class,
        \Ludows\Adminify\Interfacable\Blocks\MailCard::class,
        \Ludows\Adminify\Interfacable\Blocks\MenuCard::class,
    ]
];
