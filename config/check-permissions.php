<?php

return [
    'redirectTo' => 'home.dashboard',
    'forceRedirect' => [
        'administrator' => [], // allows all routes
        'editor' => ['users.*', 'mails.*'], //allow all routes but no users
        'subscriber' => [
            'users.index',
            'users.create',
            'users.destroy',
            'posts.*',
            'categories.*',
            'pages.*',
            'menus.*',
            'comments.*',
            'tags.*',
            'mails.*',
            'settings.*',
            'traductions.*'
        ],
    ],
];
