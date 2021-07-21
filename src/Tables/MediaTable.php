<?php

namespace Ludows\Adminify\Tables;

use Ludows\Adminify\Libs\TableManager;
use App\Models\Media as MediaModel;
use Ludows\Adminify\Dropdowns\Media as MediaDropdownsManager;

class MediaTable extends TableManager {
    public function getTemplateByName($name) {
        $ret = null;
        switch ($name) {
            case 'src':
                # code...
                $ret = 'adminify::layouts.admin.table.custom-cells.medias-src';
                break;
        }

        return $ret;
    }
    public function handle() {

        $config = config('site-settings.listings');

        $model = new MediaModel();
        $fillables = $model->getFillable();
        $datas = $this->getDatas();
        $request = $this->getRequest();
        
        if(isset($datas['results'])) {
            $medias = $datas['results'];
        }
        else {
            if($request->useMultilang) {
                $medias = MediaModel::limit( $config['limit'] )->lang($request->lang)->get();
                // dd($categories);
            }
            else {
                $medias = MediaModel::limit( $config['limit'] )->get();;
            }
        }
        

        $a = new MediaDropdownsManager($medias, []);
        // set columns
        $default_merge_columns = ['actions'];

        if($request->useMultilang && is_translatable_model($model)) {
            array_unshift($default_merge_columns, 'need_translations');
        }
        $this->columns( array_merge($fillables, $default_merge_columns) );


        foreach ($medias as $media) {
            # code...
            // pass current model
            $table = $this->model($media);
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
                'index' => $media->id
            ]);
        }


    }
}
