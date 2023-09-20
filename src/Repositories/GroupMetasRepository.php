<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class GroupMetasRepository extends BaseRepository
{
    public function beforeRun($model, $formValues,  $type) {
    //   dd($formValues);
      $model->views_name = implode(',', $formValues['views_name']);
    }

}
