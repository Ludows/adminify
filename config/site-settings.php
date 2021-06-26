<?php

return [
    'multilang' => true, // this use Laravel get text + Translatable. Please to verify your migration for correct working..
    'email_admin' => 'theartist768@gmail.com', // For logging errors etc..
    'sender_mail' => 'theartist768@gmail.com', // email used to send mail

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

    'searchable-front' => [
        'models' => [
            'page' => Ludows\Adminify\Models\Page::class,
            'post' => Ludows\Adminify\Models\Post::class,
        ],
        'fields' => [
            'page' => ['slug'],
            'post' => ['slug'],
        ]
    ],

    'shortcodes' => [

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
