<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Adminify\Models\Meta as PageModel;
use App\Adminify\Dropdowns\Metas as PageDropdownsManager;

class MetasTable extends TableManager {
    // public function getTemplateByName($name) {
    //     $ret = null;
    //     switch ($name) {
    //         case 'categories_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.pages-categories-id';
    //             break;
    //         case 'media_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.pages-media-id';
    //         case 'user_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.user-id';
    //             break;
    //         case 'no_comments':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.no-comments';
    //             break;
    //         case 'status_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.status-id';
    //             break;
    //         case 'content':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.pages-content';
    //             break;
    //         case 'parent_id':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.pages-parent-id';
    //             break;
    //     }

    //     return $ret;
    // }
    public function handle() {

        $config = config('site-settings.tables');
        $request = $this->getRequest();

        $model = new PageModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $pages = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $pages = PageModel::limit( $config['limit'] )->lang($request->lang)->get();
                // dd($categories);
                $pages = $pages->all();
            }
            else {
                $pages = PageModel::limit( $config['limit'] )->get();
            }
        }

        $a = new PageDropdownsManager($pages, []);
        
        $default_merge_columns = ['actions'];

        // if($request->useMultilang && is_translatable_model($model)) {
        //     array_unshift($default_merge_columns, 'need_translations');
        // }

        $this->columns( array_merge($fillables, $default_merge_columns) );

        // $this->module('statuses', 'top-left', 'adminify::layouts.admin.table.core.statuses', [
        //     'statuses' => Statuses::all()->all()
        // ]);

        foreach ($pages as $page) {
            # code...
            // pass current model
            $table = $this->model($page);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, null);
            }
            
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $page->id
            ]);
        }
    }
}
