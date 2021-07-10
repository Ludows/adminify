<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\User as UserModel;
use Ludows\Adminify\Dropdowns\Users as UserDropdownsManager;

class User extends TableManager {
    public function handle() {

        $u = new UserModel();

        $config = config('site-settings.listings');

        $users = UserModel::limit( $config['limit'] )->get();
        $fillables = $model->getFillable();

        // no necessary to print password..

        $a = new UserDropdownsManager($users, []);
    }
}