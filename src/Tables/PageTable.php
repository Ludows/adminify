<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Page as PageModel;
use Ludows\Adminify\Dropdowns\Page as PageDropdownsManager;

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
                $pages = PageModel::limit( $config['limit'] )->lang($request->lang);
                // dd($categories);
                $pages = $pages->all();
            }
            else {
                $pages = PageModel::limit( $config['limit'] )->get();
            }
        }

            

            $a = new PageDropdownsManager($pages, []);

            if(isset($pages) && count($pages) > 0) {
                $pages[0]->flashForMissing();
            }
        // set columns
        
        $default_merge_columns = ['categories_id','actions'];

        if($request->useMultilang) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($pages as $page) {
            # code...
            // pass current model
            $default_route_params = [
                'page' => $page->id
            ];

            $routeList = [];
            if($request->useMultilang) {
                $miss = $page->getNeededTranslations();
                if(count($miss) > 0) {
                    foreach ($miss as $missing) {
                        # code...
                        $default_route_params['lang'] = $missing;

                        $routeList[] = route('pages.edit', $default_route_params);

                    }
                }
                // $default_route_params['lang'] =  ;
            }

            $table = $this->model($page);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            
            $table->column('need_translations', 'adminify::layouts.admin.table.custom-cells.translated', [
                'routes' => $routeList,
                'missing' => $miss
            ]);
            
            $table->column('categories_id', 'adminify::layouts.admin.table.custom-cells.pages-categories-id', []);

            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $page->id
            ]);
        }


    }
}
