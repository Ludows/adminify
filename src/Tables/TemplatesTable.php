<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Templates as TemplatesModel;
use Ludows\Adminify\Dropdowns\Templates as TemplatesDropdownsManager;

class TemplatesTable extends TableManager {
    // public function getTemplateByName($name) {
    //     $ret = null;
    //     switch ($name) {
    //         case 'media_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.categories-media-id';
    //             break;
    //         case 'parent_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.categories-parent-id';
    //             break;
    //     }

    //     return $ret;
    // }
    public function handle() {

        //
        $config = config('site-settings.listings');
        $request = $this->getRequest();
        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $templates = $datas['results'];
        }
        else {
            $templates = TemplatesModel::limit( $config['limit'] )->get();
        }
        

        $model = new TemplatesModel();
        $fillables = $model->getFillable();

        $a = new TemplatesDropdownsManager($templates, []);

        $default_merge_columns = ['actions'];

        $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($templates as $template) {
            # code...
            // pass current model
            $table = $this->model($template);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, null);
            }


            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $template->id
            ]);
        }


    }
}
