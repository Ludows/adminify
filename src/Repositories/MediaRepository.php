<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{   
    public function getMimeTypeProcess($model, $formValues, $type) {
        
        $path = $model->path;

        $model->mime_type = mime_content_type($path);
    }
}
