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

    //If you want to switch with the classic template for Posts and Page . Just comment inside bind
    'editor' => [
        'handleAssetsGeneration' => 'after', // or after,
        'diskForSave' => 'public',
        'blocks' => [], // you can add here new blocks for editor
        'breakpoints' => [
            'sm' => 576,
            'md' => 768,
            'lg' => 960,
            'xl' => 1140
        ],
        'bind' => [
            'Page' => [
                'create' => 'CreatePage',
                'edit' => 'UpdatePage'
            ],  // Give the formName create / edit to bind with editor.
            'Post' => [
                'create' => 'CreatePost',
                'edit' => 'UpdatePost'
            ],  // Give the formName create / edit to bind with editor.
            'Template' => [
                'create' => 'CreateTemplates',
                'edit' => 'UpdateTemplates'
            ]
        ],
        'implicit' => [
            'hidden_fields' => [
                'content', 'title'
            ],
            'remove_fields' => [
                'submit'
            ]
        ],
        'patterns' => [
            'column_minimal' => 1,
            'column_maximal' => 12,
            'max_columns' => 6,
            'max_tooltip_items_show' => 3,
            'columns' => 'col-##BREAKPOINT##-##WIDTH##'
        ],
        'defaultsCssConfigClass' => [
            'RowWidget' => 'row',
            'TitleWidget' => 'title',
            'ColumnWidget' => 'col-12',
            'ImageWidget' => 'figure',
            'ParagraphWidget' => 'paragraph',
            'GalleryWidget' => 'gallery'
        ]
    ],

    'dynamic_forms' => [
        'default_form_template' => 'adminify::layouts.commons.forms.default',
        'show_form_when_validated' => true,
        'skip_autosend' => true,
        'default_email_user' => 'theartist768@gmail.com', // if your want to overwrite the default user. Specify form with his slug
    ],

    'adminMenu' => [
        'Page',
        'Post',
        'Category',
        'Tag',
        'Media',
        'Forms',
        'Menu',
        'Comment',
        'Settings',
        'Translations',
        'Mailables',
        'Templates',
        'User'
    ],

    'hooks' => [
        'model:creating' => [
            \App\Adminify\Hooks\OnCreatingHook::class
        ],
        'model:created' => [
            \App\Adminify\Hooks\OnCreatedHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class
        ],
        'model:updating' => [
            \App\Adminify\Hooks\OnUpdatingHook::class,
        ],
        'model:updated' => [
            \App\Adminify\Hooks\OnUpdatedHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class
        ],
        'model:deleting' => [
            \App\Adminify\Hooks\OnDeletingHook::class,
            \App\Adminify\Hooks\ContentTypesHook::class
        ],
        'model:deleted' => [
            \App\Adminify\Hooks\OnDeletedHook::class,
        ],
        'setting:created' => [
            \App\Adminify\Hooks\HandleSettings::class,
        ],
        'setting:updated' => [
            \App\Adminify\Hooks\HandleSettings::class,
        ]
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
            'Post'
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
        'form' => \App\Adminify\Shortcodes\FormShortcode::class,
        'template' => \App\Adminify\Shortcodes\TemplateShortcode::class
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
        'email' => true,
        'seo' => true,
        'templates_content' => true,
        'user' => true,
        'form' => true,
        'editor' => true
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
