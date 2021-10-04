<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Adminify\Models\Menu as MenuModel;
use App\Adminify\Dropdowns\Menu as MenuDropdownsManager;

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

        $config = config('site-settings.tables');
        $request = $this->getRequest();
        $model = new MenuModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $menus = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $menus = MenuModel::limit( $config['limit'] )->lang($request->lang)->get();
                // dd($categories);
            }
            else {
                $menus = MenuModel::limit( $config['limit'] )->get();
            }
        }


            

            $a = new MenuDropdownsManager($menus, []);

            // if(isset($menus) && count($menus) > 0) {
            //     $menus[0]->flashForMissing();
            // }
        // set columns
        $default_merge_columns = ['actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($menus as $menu) {
            # code...
            // pass current model
            $table = $this->model($menu);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }

            if($request->useMultilang && is_translatable_model($model)) {
                $table->column('need_translations', 'adminify::layouts.admin.table.custom-cells.translated', [
                    'routes' => get_missing_translations_routes('savetraductions.edit', 'savetraduction', $this->getModel()),
                    'missing' => get_missing_langs($this->getModel()),
                ]);
            }

            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $menu->id
            ]);
        }


    }
}
