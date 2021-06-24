<?php

namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
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
                        'name' => 'manage_settings'
                    ],
                    4 => [
                        'name' => 'manage_comments'
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
                        'name' => 'comment'
                    ],
                    17 => [
                        'name' => 'admin_privileges'
                    ],
                    18 => [
                        'name' => 'upload_media'
                    ],
                    19 => [
                        'name' => 'update_profile'
                    ],
                    20 => [
                        'name' => 'create_menus'
                    ],
                    21 => [
                        'name' => 'edit_menus'
                    ],
                    22 => [
                        'name' => 'delete_menus'
                    ],
                    23 => [
                        'name' => 'create_translations'
                    ]
                ]
            ],
            1 => [
                'name' => 'editor',
                'permissions' => [
                    0 => [
                        'name' => 'manage_settings'
                    ],
                    1 => [
                        'name' => 'manage_comments'
                    ],
                    2 => [
                        'name' => 'create_categories'
                    ],
                    3 => [
                        'name' => 'edit_categories'
                    ],
                    4 => [
                        'name' => 'delete_categories'
                    ],
                    5 => [
                        'name' => 'create_pages'
                    ],
                    6 => [
                        'name' => 'edit_pages'
                    ],
                    7 => [
                        'name' => 'delete_pages'
                    ],
                    8 => [
                        'name' => 'create_posts'
                    ],
                    9 => [
                        'name' => 'edit_posts'
                    ],
                    10 => [
                        'name' => 'delete_posts'
                    ],
                    11 => [
                        'name' => 'read'
                    ],
                    12 => [
                        'name' => 'comment'
                    ],
                    13 => [
                        'name' => 'upload_media'
                    ],
                    14 => [
                        'name' => 'update_profile'
                    ],
                    15 => [
                        'name' => 'create_menus'
                    ],
                    16 => [
                        'name' => 'edit_menus'
                    ],
                    17 => [
                        'name' => 'delete_menus'
                    ],
                    18 => [
                        'name' => 'create_translations'
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
                        'name' => 'comment'
                    ],
                    2 => [
                        'name' => 'update_profile'
                    ],
                    3 => [
                        'name' => 'upload_media'
                    ],
                ]
            ],

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
