<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;

class MediaRepository extends BaseRepository
{   
    public function beforeRun($model, $formValues, $type) {
        
        $map = new \League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap();

        $p = pathinfo($model->path);

        $mimeType = $map->lookupMimeType($p['extension']);

        $model->mime_type = $mimeType;
    }
}
