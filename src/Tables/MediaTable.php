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
        
        if(isset($datas['results'])) {
            $medias = $datas['results'];
        }
        else {
            $medias = MediaModel::limit( $config['limit'] )->get();
        }
        

        $a = new MediaDropdownsManager($medias, []);
        // set columns
        $this->columns( array_merge($fillables, ['actions']) );


        foreach ($medias as $media) {
            # code...
            // pass current model
            $table = $this->model($media);
            foreach ($fillables as $fillable) {
                # code...
                $table->column($fillable, $this->getTemplateByName($fillable));
            }
            $table->column('actions', 'adminify::layouts.admin.table.custom-cells.dropdown', [
                'dropdown' => $a,
                'index' => $media->id
            ]);
        }


    }
}
