<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Menu as MenuModel;
use Ludows\Adminify\Dropdowns\Menu as MenuDropdownsManager;

class MenuTable extends TableManager {
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

        $config = config('site-settings.listings');
        $request = $this->getRequest();
        $model = new MenuModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $menus = $datas;
        }
        else {
            if($request->useMultilang) {
                $menus = MenuModel::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
            }
            else {
                $menus = MenuModel::limit( $config['limit'] )->get();
            }
        }


            

            $a = new MenuDropdownsManager($menus, []);

            if(isset($menus) && count($menus) > 0) {
                $menus[0]->flashForMissing();
            }
        // set columns
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($menus as $menu) {
            # code...
            // pass current model
            $table = $this->model($menu);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $menu->id
            ]);
        }


    }
}
