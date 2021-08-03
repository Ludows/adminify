<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public $user_roles = [
        0 => ['administrator'],
        1 => ['editor'],
        2 => ['subscriber']
    ];

    public function get_user_list() {
        return [
            0 => [
                'id' => 1,
                'avatar' => null,
                'name' => 'Admin Admin',
                'email' => 'admin@argon.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            1 => [
                'id' => 2,
                'avatar' => null,
                'name' => 'Ludovic Cointrel (as client)',
                'email' => 'theartist768@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now()
            ],
            2 => [
                'id' => 3,
                'avatar' => null,
                'name' => 'Ludovic Cointrel (as simple user)',
                'email' => 'ludoco60@hotmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user_list = $this->get_user_list();
        $user_roles = $this->user_roles;
        $configRest = get_site_key('restApi');

        $tokenizable_roles = $configRest['token_capacities'];


        $key_tokens = array_keys($tokenizable_roles);

        // foreach ($user_list as $key => $value) {
        //     # code...
        // }
        $base_index = 0;
        foreach ($user_list as $user_data) {
            # code...
            DB::table('users')->insert($user_data);

            $user = User::find($user_data['id']);

            if(!empty($user_roles[$base_index])) {
                foreach ($user_roles[$base_index] as $role) {
                    # code...
                    $user->assignRole($role);

                    if($user->hasRole($role) && isset($tokenizable_roles[$role]) && !empty($tokenizable_roles[$role]) && $configRest['enable'] ) {
                        foreach ($tokenizable_roles[$role] as $tokenType) {
                            # code...
                            $user->createToken($configRest['token_name'], $tokenType);
                        }
                    }
                }
            }
            // $user->assignRole($user_roles[$base_index]);

            // if(in_array($user_roles[$base_index], ))

            $base_index++;
        }
    }
}
