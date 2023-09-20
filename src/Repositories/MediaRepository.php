<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{   
    public function afterRun($model, $formValues, $type) {
        
        if($type == 'create') {
            $model->setThumbs([]);
        }

        if($type == 'destroy') {
            $model->deleteThumbs([]);
        }
        
    }
}
