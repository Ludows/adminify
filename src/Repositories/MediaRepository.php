<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{   
    public function getMimeTypeProcess($model, $formValues, $type) {
        
        $path = $model->getFullPath($model->src) . '/' . $model->src;

        $model->mime_type = mime_content_type($path);
    }
}
