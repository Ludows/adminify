<?php
namespace Ludows\Adminify\Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user_list = [
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

        $user_roles = [
            'administrator',
            'editor',
            'subscriber'
        ];

        // foreach ($user_list as $key => $value) {
        //     # code...
        // }
        $base_index = 0;
        foreach ($user_list as $user_data) {
            # code...
            DB::table('users')->insert($user_data);

            $user = User::find($user_data['id']);

            // var_dump($user);

            $user->assignRole($user_roles[$base_index]);

            $base_index++;
        }
    }
}
