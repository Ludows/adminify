<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Category as CategoryModel;
use Ludows\Adminify\Dropdowns\Category as CategoryDropdownsManager;

class CategoryTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'media_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.categories-media-id';
                break;
            case 'parent_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.categories-parent-id';
                break;
        }

        return $ret;
    }
    public function handle() {

        //
        $config = config('site-settings.listings');
        $request = $this->getRequest();
        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $categories = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $categories = CategoryModel::limit( $config['limit'] )->lang($request->lang);
            }
            else {
                $categories = CategoryModel::limit( $config['limit'] )->get();
            }
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
