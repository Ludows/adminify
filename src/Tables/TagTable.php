<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Tag as TagModel;
use Ludows\Adminify\Dropdowns\Tags as TagDropdownManager;

class TagTable extends TableManager {
    // public function getTemplateByName($name) {
    //     $ret = null;
    //     switch ($name) {
    //         case 'avatar':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.users-avatar';
    //             break;
    //         case 'email':
    //         case 'name':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.cell';
    //             break;
    //         case 'password':
    //             # code...
    //             $ret = 'adminify::layouts.admin.table.custom-cells.users-password';
    //             break;
    //     }

    //     return $ret;
    // }
    public function handle() {

        $config = config('site-settings.listings');
        $request = $this->getRequest();

        $model = new TagModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $tags = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $tags = TagModel::limit( $config['limit'] )->lang($request->lang)->get();
            }
            else {
                $tags = TagModel::limit( $config['limit'] )->get();
            }
        }
           
        //call the dropdown manager
        $a = new TagDropdownManager($tags ,[]);

        // if(isset($trans) && count($trans) > 0) {
        //     $trans[0]->flashForMissing();
        // }
        // set columns
        $default_merge_columns = ['actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );

        foreach ($tags as $tag) {
            # code...
            // pass current model
            $table = $this->model($tag);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, null);
            }
            
            if($request->useMultilang && is_translatable_model($model)) {
                $table->column('need_translations', 'adminify::layouts.admin.table.custom-cells.translated', [
                    'routes' => get_missing_translations_routes('savetraductions.edit', 'savetraduction', $this->getModel()),
                    'missing' => get_missing_langs($this->getModel()),
                ]);
            }

            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $tag->id
            ]);
        }


    }
}