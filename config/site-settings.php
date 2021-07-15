<?php

return [
    'multilang' => env('ENABLE_MULTILANG', true), // this use Translatable. Please to verify your migration for correct working..
    'email_admin' => env('EMAIL_ADMIN', 'theartist768@gmail.com'), // For logging errors etc..
    'sender_mail' => env('SENDER_MAIL', 'theartist768@gmail.com'), // email used to send mail

    'models' => [
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
    ],

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'category' => App\Models\Category::class,
            'page' => App\Models\Page::class,
            'post' => App\Models\Post::class,
            'custom' => App\Models\CustomLink::class
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
                'posts' => \App\Models\Post::class,
                'users' => \App\Models\User::class,
                'menus' => \App\Models\Menu::class,
                'pages' => \App\Models\Page::class,
                'traductions' => \App\Models\Translations::class
            ],
            'labels' => [
                'posts' => 'title',
                'users' => 'name',
                'menus' => 'title',
                'pages' => 'title',
                'traductions' => 'key'
            ],
            'limit' => 5,
            'name' => 'query'
        ]
    ],

    
    'savetraductions' => [
        'post' => [
            'model' => \App\Models\Post::class,
            'clsForm' => \App\Forms\UpdatePost::class,
            'excludes' => [
                'media_id',
                'parent_id'
            ],
            'unmodifiedFields' => [
                'content',
                'categories_id',
                'submit'
            ]

        ],
        'page' => [
            'model' => \App\Models\Page::class,
            'clsForm' => \App\Forms\CreatePage::class,
            'excludes' => [
                'media_id',
                'parent_id'
            ],
            'unmodifiedFields' => [
                'content',
                'categories_id',
                'submit'
            ]
        ],
        'traduction' => [
            'model' => \App\Models\Translations::class,
            'clsForm' => \App\Forms\UpdateTranslation::class,
            'excludes' => [],
            'unmodifiedFields' => []
        ],
        'category' => [
            'model' => \App\Models\Category::class,
            'clsForm' => \App\Forms\UpdateCategory::class,
            'excludes' => [
                'media_id',
                'parent_id'
            ],
            'unmodifiedFields' => [
                'submit'
            ]
        ],
        'menu' => [
            'model' => \App\Models\Menu::class,
            'clsForm' => null,
            'excludes' => [],
            'unmodifiedFields' => [
                'submit'
            ]
        ],
        'fallback' => 'request' // if no class form provided . request->all() is intended,

    ],

    'sitemap' => [
        \App\Models\Post::class,
        \App\Models\Page::class,
        \App\Models\Category::class,
        \App\Models\Media::class,
    ],

    'shortcodes' => [
    ],

    // // this key is called when page is fetched for front
    // 'handleFront' => [
    //     'models' => [

    //     ],
    //     'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
    // ],

    // all routes search are binded to singular route name.
    'listings' => [
        'limit' => env('LISTINGS_LIMIT', 5),
        'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
        'search' => [
            'media' => [
                'tableManager' => \Ludows\Adminify\Tables\MediaTable::class,
                'class' => \App\Models\Media::class,
                'columns' => []
            ],
            'post' => [
                'tableManager' => \Ludows\Adminify\Tables\PostTable::class,
                'class' => \App\Models\Post::class,
                'columns' => []
            ],
            'user' => [
                'tableManager' => \Ludows\Adminify\Tables\UserTable::class,
                'class' => \App\Models\User::class,
                'columns' => []
            ],
            'menu' => [
                'tableManager' => \Ludows\Adminify\Tables\MenuTable::class,
                'class' => \App\Models\Menu::class,
                'columns' => []
            ],
            'page' => [
                'tableManager' => \Ludows\Adminify\Tables\PageTable::class,
                'class' => \App\Models\Page::class,
                'columns' => []
            ],
            'category' => [
                'tableManager' => \Ludows\Adminify\Tables\CategoryTable::class,
                'class' => \App\Models\Category::class,
                'columns' => []
            ],
            'comment' => [
                'tableManager' => \Ludows\Adminify\Tables\CommentTable::class,
                'class' => \App\Models\Comment::class,
                'columns' => []
            ],
            'traduction' => [
                'tableManager' => \Ludows\Adminify\Tables\TranslationTable::class,
                'class' => \App\Models\Translations::class,
                'columns' => []
            ],
        ]
    ],

    // this is possible for all website ( front and back )
    'restApi' => [
        'enable' => true, // resets to false to disable entierely rest api
        'prefix' => 'api', // use prefix
        'domain' => null, // to set a domain, just replace by your domain,
        'token_name' => 'api-token',
        'token_capacities' => [
            'guest' => [
                'api:readonly',
            ],
            'authentificated' => [
                'api:full' // update, read, create, delete
            ]
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
        'limit' => 3,
        'blocks' => [
            'page' => [
                'class' => \App\Models\Page::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-page',
                'columnShow' => 'title',
            ],
            'post' => [
                'class' => \App\Models\Post::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-post',
                'columnShow' => 'title',
            ],
            'media' => [
                'class' => \App\Models\Media::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-media',
                'columnShow' => 'title',
                'plural' => 'medias'
            ],
            'category' => [
                'class' => \App\Models\Category::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-category',
                'columnShow' => 'title',
            ],
            'traduction' => [
                'class' => \App\Models\Translations::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-traduction',
                'columnShow' => 'key',
            ],
            'comment' => [
                'class' => \App\Models\Comment::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-comment',
                'columnShow' => 'comment',
            ],
        ]
    ]
];
