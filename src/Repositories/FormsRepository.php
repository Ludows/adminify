<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
class FormsRepository extends BaseRepository
{
    public $external_relations_columns = [
        'fields_id'
    ];

    public function getExternalFieldsId($model, $formValues, $type) {
        if(!isset($formValues['fields_id']) && $type == "update") {
            $model->fields()->detach();
        }
        if(isset($formValues['fields_id']) && count($formValues['fields_id']) > 0) {
            if($type == "update") {
                $model->fields()->detach();
            }
            foreach ($formValues['fields_id'] as $field => $fieldId) {
                # code...
                $model->fields()->attach((int) $fieldId);
            }
        }
    }
}
