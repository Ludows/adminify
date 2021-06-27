<?php

return [
    'multilang' => env('ENABLE_MULTILANG', true), // this use Laravel get text + Translatable. Please to verify your migration for correct working..
    'email_admin' => env('EMAIL_ADMIN', 'theartist768@gmail.com'), // For logging errors etc..
    'sender_mail' => env('SENDER_MAIL', 'theartist768@gmail.com'), // email used to send mail

    // menu builder is automatic sync with multilang param.
    'menu-builder' => [
        'models' => [
            'category' => Ludows\Adminify\Models\Category::class,
            'page' => Ludows\Adminify\Models\Page::class,
            'post' => Ludows\Adminify\Models\Post::class,
            'custom' => Ludows\Adminify\Models\CustomLink::class
        ],
        'showAlways' => [
            'custom' => [ // you can pass some field to build your form
                'title' => ['type' => 'text', 'options' => []],
                'url' => ['type' => 'text', 'options' => []],
                'open_new_tab' => ['type' => 'checkbox', 'options' => []]
            ]
        ]
    ],

    // please to pay attention that your models implements Searchable.
    'searchable' => [
        'admin' => [
            'models' => [
                'posts' => \Ludows\Adminify\Models\Post::class,
                'users' => \Ludows\Adminify\Models\User::class,
                'menus' => \Ludows\Adminify\Models\Menu::class,
                'pages' => \Ludows\Adminify\Models\Page::class,
                'traductions' => \Ludows\Adminify\Models\Translations::class
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

    'shortcodes' => [
    ],

    // all routes search are binded to singular route name.
    'listings' => [
        'limit' => env('LISTINGS_LIMIT', 5),
        'searchType' => 'fillable', // or manual. In manual mode, columns is necessary.
        'search' => [
            'post' => [
                'class' => \Ludows\Adminify\Models\Post::class,
                'columns' => []
            ],
            'user' => [
                'class' => \Ludows\Adminify\Models\User::class,
                'columns' => []
            ],
            'menu' => [
                'class' => \Ludows\Adminify\Models\Menu::class,
                'columns' => []
            ],
            'page' => [
                'class' => \Ludows\Adminify\Models\Page::class,
                'columns' => []
            ],
            'category' => [
                'class' => \Ludows\Adminify\Models\Category::class,
                'columns' => []
            ],
            'comment' => [
                'class' => \Ludows\Adminify\Models\Comment::class,
                'columns' => []
            ],
            'traduction' => [
                'class' => \Ludows\Adminify\Models\Translations::class,
                'columns' => []
            ],
        ]
    ],

    'dashboard' => [
        'limit' => 3,
        'blocks' => [
            'page' => [
                'class' => Ludows\Adminify\Models\Page::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-page',
                'columnShow' => 'title',
            ],
            'post' => [
                'class' => Ludows\Adminify\Models\Post::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-post',
                'columnShow' => 'title',
            ],
            'media' => [
                'class' => Ludows\Adminify\Models\Media::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-media',
                'columnShow' => 'title',
                'plural' => 'medias'
            ],
            'category' => [
                'class' => Ludows\Adminify\Models\Category::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-category',
                'columnShow' => 'title',
            ],
            'traduction' => [
                'class' => Ludows\Adminify\Models\Translations::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-traduction',
                'columnShow' => 'key',
            ],
            'comment' => [
                'class' => Ludows\Adminify\Models\Comment::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'adminify::layouts.admin.dashboard.card-comment',
                'columnShow' => 'comment',
            ],
        ]
    ]
];
