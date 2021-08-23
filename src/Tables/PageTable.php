<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Page as PageModel;
use Ludows\Adminify\Dropdowns\Page as PageDropdownsManager;

use App\Models\Statuses;

class PageTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'categories_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.pages-categories-id';
                break;
            case 'media_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.pages-media-id';
            case 'user_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.user-id';
                break;
            case 'content':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.pages-content';
                break;
            case 'parent_id':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.pages-parent-id';
                break;
        }

        return $ret;
    }
    public function handle() {

        $config = config('site-settings.listings');
        $request = $this->getRequest();

        $model = new PageModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $pages = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $pages = PageModel::limit( $config['limit'] )->status(Statuses::TRASHED_ID, '!=')->lang($request->lang)->get();
                // dd($categories);
                $pages = $pages->all();
            }
            else {
                $pages = PageModel::limit( $config['limit'] )->status(Statuses::TRASHED_ID, '!=')->get();
            }
        }

        $a = new PageDropdownsManager($pages, []);
        
        $default_merge_columns = ['categories_id','actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );

        $this->module('statuses', 'top-left', 'adminify::layouts.admin.table.core.statuses', [
            'statuses' => Statuses::all()->all()
        ]);

        foreach ($pages as $page) {
            # code...
            // pass current model
            $table = $this->model($page);
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
            
            
            
            $table->column('categories_id', 'adminify::layouts.admin.table.custom-cells.pages-categories-id', []);

            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $page->id
            ]);
        }
    }
}
