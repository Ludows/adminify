<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Adminify\Models\FormEntries as FormModel;
use App\Adminify\Dropdowns\FormEntries as FormDropdownsManager;

class FormEntriesTable extends TableManager {
    public function __construct() {
        parent::__construct();
        $this->showBtnCreate = false;
    }
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            // case 'categories_id':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.posts-categories-id';
            //     break;
            // case 'media_id':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.posts-media-id';
            //     break;
            // case 'user_id':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.user-id';
            //     break;
            // case 'no_comments':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.no-comments';
            //     break;
            // case 'status_id':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.status-id';
            //     break;
            // case 'content':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.posts-content';
            //     break;
            // case 'parent_id':
            //     # code...
            //     $ret = 'adminify::layouts.admin.table.custom-cells.posts-parent-id';
            //     break;
        }

        return $ret;
    }
    public function handle() {

        $config = config('site-settings.tables');
        $request = $this->getRequest();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $entries = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $entries = FormModel::limit( $config['limit'] )->lang($request->lang)->get();
                // dd($categories);
            }
            else {
                $entries = FormModel::limit( $config['limit'] )->get();
            }
        }
            $model = new FormModel();
            $fillables = $model->getFillable();

            $a = new FormDropdownsManager($entries, []);

            // if(isset($posts) && count($posts) > 0) {
            //     $posts[0]->flashForMissing();
            // }

            $default_merge_columns = ['actions'];

            if($request->useMultilang && is_translatable_model($model)) {
                array_unshift($default_merge_columns, 'need_translations');
            }

            $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($entries as $entry) {
            # code...
            // pass current model
            $table = $this->model($entry);
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
                'index' => $entry->id
            ]);
        }


    }
}
