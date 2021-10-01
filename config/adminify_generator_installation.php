<?php

return [
    'settings' => [
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
        'adminify:install:middleware' => [
            'namespace'           => '\Adminify\Http\Middleware',
            'path'                => './app/Adminify/Http/Middleware',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:requests' => [
            'namespace'           => '\Adminify\Http\Requests',
            'path'                => './app/Adminify/Http/Requests',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:interfacable' => [
            'namespace'           => '\Adminify\Interfacable',
            'path'                => './app/Adminify/Interfacable',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:interfacable:blocks' => [
            'namespace'           => '\Adminify\Interfacable\Blocks',
            'path'                => './app/Adminify/Interfacable/Blocks',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:interfacable:listeners' => [
            'namespace'           => '\Adminify\Listeners',
            'path'                => './app/Adminify/Listeners',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:mails' => [
            'namespace'           => '\Adminify\Mails',
            'path'                => './app/Adminify/Mails',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:models' => [
            'namespace'           => '\Adminify\Models',
            'path'                => './app/Adminify/Models',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:repositories' => [
            'namespace'           => '\Adminify\Repositories',
            'path'                => './app/Adminify/Repositories',
            'postfix'             => '',
            'directory_namespace' => true,
        ],
        'adminify:install:tables' => [
            'namespace'           => '\Adminify\Tables',
            'path'                => './app/Adminify/Tables',
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
        'adminify:install:middleware' => base_path() . '/resources/stubs/mdlware_install.stub',
        'adminify:install:requests' => base_path() . '/resources/stubs/requests_install.stub',
        'adminify:install:interfacable' => base_path() . '/resources/stubs/interfacable_install.stub',
        'adminify:install:interfacable:blocks' => base_path() . '/resources/stubs/interfacable_block_install.stub',
        'adminify:install:interfacable:listeners' => base_path() . '/resources/stubs/listeners_install.stub',
        'adminify:install:mails' => base_path() . '/resources/stubs/mails_install.stub',
        'adminify:install:models' => base_path() . '/resources/stubs/models_install.stub',
        'adminify:install:repositories' => base_path() . '/resources/stubs/repositories_install.stub',
        'adminify:install:tables' => base_path() . '/resources/stubs/tables_install.stub',
    ]
];