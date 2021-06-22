<?php

return [
    'redirectTo' => 'home.dashboard',
    'forceRedirect' => [
        'administrator' => [], // allows all routes
        'editor' => ['users.*'], //allow all routes but no users
        'subscriber' => [
            'users.index',
            'users.create',
            'users.destroy',
            'posts.*',
            'categories.*',
            'pages.*',
            'menus.*',
            'comments.*',
            'settings.*'
        ],
    ],
];
