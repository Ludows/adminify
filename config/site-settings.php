<?php

return [
    'multilang' => true, // this use Laravel get text + Translatable. Please to verify your migration for correct working..
    'email_admin' => 'theartist768@gmail.com', // For logging errors etc..
    'sender_mail' => 'theartist768@gmail.com', // email used to send mail

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

    'searchable-front' => [
        'models' => [
            'page' => App\Models\Page::class,
            'post' => App\Models\Post::class,
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
                'class' => App\Models\Page::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-page',
                'columnShow' => 'title',
            ],
            'post' => [
                'class' => App\Models\Post::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-post',
                'columnShow' => 'title',
            ],
            'media' => [
                'class' => App\Models\Media::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-media',
                'columnShow' => 'title',
                'plural' => 'medias'
            ],
            'category' => [
                'class' => App\Models\Category::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-category',
                'columnShow' => 'title',
            ],
            'traduction' => [
                'class' => App\Models\Traduction::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-traduction',
                'columnShow' => 'key',
            ],
            'comment' => [
                'class' => App\Models\Comment::class,
                'showIf' => ['administrator', 'client'],
                'template' => 'layouts.admin.dashboard.card-comment',
                'columnShow' => 'comment',
            ],
        ]
    ]
];
