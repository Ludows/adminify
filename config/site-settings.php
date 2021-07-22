<?php

return [
    'multilang' => env('ENABLE_MULTILANG', true), // this use Translatable. Please to verify your migration for correct working..
    'email_admin' => env('EMAIL_ADMIN', 'theartist768@gmail.com'), // For logging errors etc..
    'sender_mail' => env('SENDER_MAIL', 'theartist768@gmail.com'), // email used to send mail
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
        'tags' => \App\Models\Tag::class
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

    'shortcodes' => [
    ],

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'category' => 'register.categories',
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
        'post' => [
            'model' => 'register.posts',
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
            'model' => 'register.pages',
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
        'translation' => [
            'model' => 'register.traductions',
            'clsForm' => \App\Forms\UpdateTranslation::class,
            'excludes' => [],
            'unmodifiedFields' => []
        ],
        'category' => [
            'model' => 'register.categories',
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
            'model' => 'register.menus',
            'clsForm' => null,
            'excludes' => [],
            'unmodifiedFields' => [
                'submit'
            ]
        ],
        'tag' => [
            'model' => 'register.tags',
            'clsForm' => null,
            'excludes' => [],
            'unmodifiedFields' => [
                'submit'
            ]
        ],
        'fallback' => 'request' // if no class form provided . request->all() is intended,

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
            'tag' => 'register.tags'
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
                'class' => 'register.pages',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-page',
                'columnShow' => 'title',
            ],
            'post' => [
                'class' => 'register.posts',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-post',
                'columnShow' => 'title',
            ],
            'media' => [
                'class' => 'register.medias',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-media',
                'columnShow' => 'title',
                'plural' => 'medias'
            ],
            'category' => [
                'class' => 'register.categories',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-category',
                'columnShow' => 'title',
            ],
            'traduction' => [
                'class' => 'register.traductions',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-traduction',
                'columnShow' => 'key',
            ],
            'comment' => [
                'class' => 'register.comments',
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-comment',
                'columnShow' => 'comment',
            ],
        ]
    ]
];
