<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Translations as TranslationModel;
use Ludows\Adminify\Dropdowns\Translations as TranslationDropdownManager;

class TranslationTable extends TableManager {
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

        $model = new TranslationModel();
        $fillables = $model->getFillable();

        $datas = $this->getDatas();

        if(isset($datas['results'])) {
            $trans = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $trans = TranslationModel::limit( $config['limit'] )->lang($request->lang);
                    // dd($categories);
            }
            else {
                $trans = TranslationModel::limit( $config['limit'] )->get();
            }
        }
           
        //call the dropdown manager
        $a = new TranslationDropdownManager($trans ,[]);

        // if(isset($trans) && count($trans) > 0) {
        //     $trans[0]->flashForMissing();
        // }
        // set columns
        $default_merge_columns = ['actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }

        $this->columns( array_merge($fillables, $default_merge_columns) );

        foreach ($trans as $t) {
            # code...
            // pass current model
            $table = $this->model($t);
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
                'index' => $t->id
            ]);
        }


    }
}
