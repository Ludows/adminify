<?php

return [
    'types' => [
        'adminify:install:commands' => [
            'namespace'           => '\Adminify\Console\Commands',
            'path'                => './app/Adminify/Console/Commands/',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:dropdowns' => [
            'namespace'           => '\Adminify\Dropdowns',
            'path'                => './app/Adminify/Dropdowns/',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:forms' => [
            'namespace'           => '\Adminify\Forms',
            'path'                => './app/Adminify/Forms/',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:hooks' => [
            'namespace'           => '\Adminify\Hooks',
            'path'                => './app/Adminify/Hooks/',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:controllers' => [
            'namespace'           => '\Adminify\Http\Controllers',
            'path'                => './app/Adminify/Http/Controllers',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:controllers:api' => [
            'namespace'           => '\Adminify\Http\Controllers\Api',
            'path'                => './app/Adminify/Http/Controllers/Api',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:controllers:auth' => [
            'namespace'           => '\Adminify\Http\Controllers\Auth',
            'path'                => './app/Adminify/Http/Controllers/Auth',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:controllers:back' => [
            'namespace'           => '\Adminify\Http\Controllers\Back',
            'path'                => './app/Adminify/Http/Controllers/Back',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:controllers:front' => [
            'namespace'           => '\Adminify\Http\Controllers\Front',
            'path'                => './app/Adminify/Http/Controllers/Front',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
    ],
    'stubs' => [
        'adminify:install:commands'         => base_path() . '/resources/stubs/commands_install.stub',
        'adminify:install:dropdowns'         => base_path() . '/resources/stubs/dropdowns_install.stub',
        'adminify:install:feeds'         => base_path() . '/resources/stubs/feeds_install.stub',
        'adminify:install:forms'         => base_path() . '/resources/stubs/forms_install.stub',
        'adminify:install:hooks'         => base_path() . '/resources/stubs/hooks_install.stub',
        'adminify:install:controllers' => base_path() . '/resources/stubs/ctrl_install.stub',
        'adminify:install:controllers:api' => base_path() . '/resources/stubs/ctrl_api_install.stub',
        'adminify:install:controllers:auth' => base_path() . '/resources/stubs/ctrl_auth_install.stub',
        'adminify:install:controllers:back' => base_path() . '/resources/stubs/ctrl_back_install.stub',
        'adminify:install:controllers:front' => base_path() . '/resources/stubs/ctrl_front_install.stub',
    ]
];