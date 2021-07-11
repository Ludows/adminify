<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Category as CategoryModel;
use Ludows\Adminify\Dropdowns\Category as CategoryDropdownsManager;

class CommentTable extends TableManager {
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

        //
        $config = config('site-settings.listings');
        $request = $this->getRequest();

        if($request->useMultilang) {
            $categories = CategoryModel::limit( $config['limit'] )->lang($request->lang);
            // dd($categories);
            // $categories = $categories->all()->limit( $config['limit'] )->get();
        }
        else {
            $categories = CategoryModel::limit( $config['limit'] )->get();
        }

        $model = new CategoryModel();
        $fillables = $model->getFillable();

        $a = new CategoryDropdownsManager($categories, []);

        if(isset($categories) && count($categories) > 0) {
            $categories[0]->flashForMissing();
        }

        // set columns
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($categories as $category) {
            # code...
            // pass current model
            $table = $this->model($category);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $category->id
            ]);
        }


    }
}
