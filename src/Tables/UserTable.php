<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\User as UserModel;
use Ludows\Adminify\Dropdowns\Users as UserDropdownsManager;

class UserTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'avatar':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.users-avatar';
                break;
            case 'email':
            case 'name':
                # code...
                $ret = 'adminify::layouts.admin.table.cell';
                break;
            case 'password':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.users-password';
                break;
        }

        return $ret;
    }
    public function handle() {

        $u = new UserModel();

        $config = config('site-settings.listings');
        $fillables = $u->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $users = $datas['results'];
        }
        else {
            $users = UserModel::whereRaw('LENGTH(email) > 0')->limit( $config['limit'] )->get();
        }

        // set columns
        $this->columns( array_merge($fillables, ['actions']) );

        //call the dropdown manager
        $a = new UserDropdownsManager($users, []);

        foreach ($users as $user) {
            # code...
            // pass current model
            $table = $this->model($user);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $user->id
            ]);
        }


    }
}
