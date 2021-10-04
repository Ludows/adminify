<?php

namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Adminify\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles_list = [
            0 => [
                'name' => 'administrator',
                'permissions' => [
                    0 => [
                        'name' => 'create_users'
                    ],
                    1 => [
                        'name' => 'delete_users'
                    ],
                    2 => [
                        'name' => 'edit_users'
                    ],
                    3 => [
                        'name' => 'create_settings'
                    ],
                    4 => [
                        'name' => 'edit_settings'
                    ],
                    5 => [
                        'name' => 'delete_settings'
                    ],
                    6 => [
                        'name' => 'create_comments'
                    ],
                    7 => [
                        'name' => 'edit_comments'
                    ],
                    8 => [
                        'name' => 'delete_comments'
                    ],
                    6 => [
                        'name' => 'create_categories'
                    ],
                    7 => [
                        'name' => 'edit_categories'
                    ],
                    8 => [
                        'name' => 'delete_categories'
                    ],
                    9 => [
                        'name' => 'create_pages'
                    ],
                    10 => [
                        'name' => 'edit_pages'
                    ],
                    11 => [
                        'name' => 'delete_pages'
                    ],
                    12 => [
                        'name' => 'create_posts'
                    ],
                    13 => [
                        'name' => 'edit_posts'
                    ],
                    14 => [
                        'name' => 'delete_posts'
                    ],
                    15 => [
                        'name' => 'read'
                    ],
                    16 => [
                        'name' => 'create_medias'
                    ],
                    17 => [
                        'name' => 'edit_medias'
                    ],
                    18 => [
                        'name' => 'delete_medias'
                    ],
                    19 => [
                        'name' => 'upload_media'
                    ],
                    20 => [
                        'name' => 'admin_privileges'
                    ],
                    21 => [
                        'name' => 'update_profile'
                    ],
                    22 => [
                        'name' => 'create_menus'
                    ],
                    23 => [
                        'name' => 'edit_menus'
                    ],
                    24 => [
                        'name' => 'delete_menus'
                    ],
                    25 => [
                        'name' => 'create_translations'
                    ],
                    26 => [
                        'name' => 'edit_translations'
                    ],
                    27 => [
                        'name' => 'delete_translations'
                    ],
                    28 => [
                        'name' => 'create_mails'
                    ],
                    29 => [
                        'name' => 'edit_mails'
                    ],
                    30 => [
                        'name' => 'delete_mails'
                    ],
                    31 => [
                        'name' => 'create_templates'
                    ],
                    32 => [
                        'name' => 'edit_templates'
                    ],
                    33 => [
                        'name' => 'delete_templates'
                    ],
                    34 => [
                        'name' => 'create_tags'
                    ],
                    35 => [
                        'name' => 'edit_tags'
                    ],
                    36 => [
                        'name' => 'delete_tags'
                    ],
                    37 => [
                        'name' => 'create_forms'
                    ],
                    38 => [
                        'name' => 'edit_forms'
                    ],
                    39 => [
                        'name' => 'delete_forms'
                    ]
                ]
            ],
            1 => [
                'name' => 'editor',
                'permissions' => [
                    0 => [
                        'name' => 'create_settings'
                    ],
                    1 => [
                        'name' => 'edit_settings'
                    ],
                    2 => [
                        'name' => 'delete_settings'
                    ],
                    3 => [
                        'name' => 'create_comments'
                    ],
                    4 => [
                        'name' => 'edit_comments'
                    ],
                    5 => [
                        'name' => 'delete_comments'
                    ],
                    6 => [
                        'name' => 'create_categories'
                    ],
                    7 => [
                        'name' => 'edit_categories'
                    ],
                    8 => [
                        'name' => 'delete_categories'
                    ],
                    9 => [
                        'name' => 'create_pages'
                    ],
                    10 => [
                        'name' => 'edit_pages'
                    ],
                    11 => [
                        'name' => 'delete_pages'
                    ],
                    12 => [
                        'name' => 'create_posts'
                    ],
                    13 => [
                        'name' => 'edit_posts'
                    ],
                    14 => [
                        'name' => 'delete_posts'
                    ],
                    15 => [
                        'name' => 'read'
                    ],
                    16 => [
                        'name' => 'create_medias'
                    ],
                    17 => [
                        'name' => 'edit_medias'
                    ],
                    18 => [
                        'name' => 'delete_medias'
                    ],
                    19 => [
                        'name' => 'upload_media'
                    ],
                    20 => [
                        'name' => 'update_profile'
                    ],
                    21 => [
                        'name' => 'create_menus'
                    ],
                    22 => [
                        'name' => 'edit_menus'
                    ],
                    23 => [
                        'name' => 'delete_menus'
                    ],
                    24 => [
                        'name' => 'create_translations'
                    ],
                    25 => [
                        'name' => 'edit_translations'
                    ],
                    26 => [
                        'name' => 'delete_translations'
                    ],
                    27 => [
                        'name' => 'create_mails'
                    ],
                    28 => [
                        'name' => 'edit_mails'
                    ],
                    29 => [
                        'name' => 'delete_mails'
                    ],
                    30 => [
                        'name' => 'create_templates'
                    ],
                    31 => [
                        'name' => 'edit_templates'
                    ],
                    32 => [
                        'name' => 'delete_templates'
                    ],
                    33 => [
                        'name' => 'create_tags'
                    ],
                    34 => [
                        'name' => 'edit_tags'
                    ],
                    35 => [
                        'name' => 'delete_tags'
                    ],
                    36 => [
                        'name' => 'create_forms'
                    ],
                    37 => [
                        'name' => 'edit_forms'
                    ],
                    38 => [
                        'name' => 'delete_forms'
                    ]
                ]
            ],
            2 => [
                'name' => 'subscriber',
                'permissions' => [
                    0 => [
                        'name' => 'read'
                    ],
                    1 => [
                        'name' => 'update_profile'
                    ],
                    2 => [
                        'name' => 'upload_media'
                    ],
                ]
            ],
            3 => [
                'name' => 'guest',
                'permissions' => [
                    0 => [
                        'name' => 'read'
                    ],
                ]
            ]

        ];

        foreach ($roles_list as $role) {
            # code...
            $r = Role::create(['name' => $role['name']]);

            foreach ($role['permissions'] as $permission) {
                # code...
                $check = Permission::where('name', $permission['name'])->first();
                if(!isset($check)) {
                    $perm = Permission::create(['name' => $permission['name']]);
                }
                else {
                    $perm = $check;
                }

                $r->givePermissionTo($perm);
            }

        }


    }
}
