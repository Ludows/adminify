<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
class FormsRepository extends BaseRepository
{
    public $external_relations_columns = [
        'fields_id'
    ];

    public function getExternalFieldsId($model, $formValues, $type) {

    }
}
