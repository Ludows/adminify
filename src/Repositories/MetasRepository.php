<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class MetasRepository extends BaseRepository
{
    public function beforeRun($model, $formValues, $type) {
        if(!empty($formValues['value']) && is_array($formValues['value'])) {
            $model->value = join(",", $formValues['value']);
        }
    }
}
