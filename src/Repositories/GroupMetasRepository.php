<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class GroupMetasRepository extends BaseRepository
{
    public function beforeRun($model, $formValues,  $type) {
      $model->view_name = implode(',', $formValues['view_name']);
    }
    
}
