<?php

namespace Ludows\Adminify\Repositories;

use Ludows\Adminify\Repositories\BaseRepository;

class FormTraceRepository extends BaseRepository
{
    public $external_relations_columns = [
        'entries'
    ];

    public function getExternalEntriesRelationship($model, $formValues, $type) {
        dd($model, $formValues, $type);
    }

}
