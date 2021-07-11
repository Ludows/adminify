<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Page as PageModel;
use Ludows\Adminify\Dropdowns\Page as PageDropdownsManager;

class PageTable extends TableManager {
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
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($pages as $page) {
            # code...
            // pass current model
            $table = $this->model($page);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $page->id
            ]);
        }


    }
}
