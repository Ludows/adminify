<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\User as UserModel;
use Ludows\Adminify\Dropdowns\Users as UserDropdownsManager;

class UserTable extends TableManager {
    public function handle() {

        $u = new UserModel();

        $config = config('site-settings.listings');

        $users = UserModel::limit( $config['limit'] )->get();
        $fillables = $u->getFillable();

        // no necessary to print password..
        $this->setTh($fillables);

        // $

        $a = new UserDropdownsManager($users, []);

        foreach ($users as $user) {
            # code...
            // pass current model
            $table = $this->model($user);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, 'view_name');
            }
        }


    }
}