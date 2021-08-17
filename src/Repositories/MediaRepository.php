<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{   
    public function getMimeTypeProcess($model, $formValues, $type) {
        $model->mime_type = mime_content_type($model->src);
    }
}
