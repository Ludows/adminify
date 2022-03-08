<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class GroupMetasRepository extends BaseRepository
{
    public function beforeRun($model, $formValues,  $type) {
      $model->views_name = implode(',', $formValues['views_name']);
    }
    
}
