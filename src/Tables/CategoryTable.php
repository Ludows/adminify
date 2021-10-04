<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Adminify\Models\Category as CategoryModel;
use App\Adminify\Dropdowns\Category as CategoryDropdownsManager;

class CategoryTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'media_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.categories-media-id';
                break;
            case 'user_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.user-id';
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
        $config = config('site-settings.tables');
        $request = $this->getRequest();
        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $categories = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $categories = CategoryModel::limit( $config['limit'] )->lang($request->lang)->get();
            }
            else {
                $categories = CategoryModel::limit( $config['limit'] )->get();
            }
        }
        

        $model = new CategoryModel();
        $fillables = $model->getFillable();

        $a = new CategoryDropdownsManager($categories, []);

        $default_merge_columns = ['actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($categories as $category) {
            # code...
            // pass current model
            $table = $this->model($category);
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
                'index' => $category->id
            ]);
        }


    }
}
