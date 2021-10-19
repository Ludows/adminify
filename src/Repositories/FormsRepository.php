<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
use App\Adminify\Models\FormField;
use App\Adminify\Repositories\FormFieldsRepository;

class FormsRepository extends BaseRepository
{
    // set for only linking to pivot table
    public $external_relations_columns = [
        'fields'
    ];

    //set as interval for register or update fields objects
    public $internal_relations_columns = [
        'fields'
    ];

    public function getInternalFieldsRelationship($model, $formValues, $type) {
        dd('internal', $formValues);
    }


    public function getExternalFieldsRelationship($model, $formValues, $type) {
        dd('external',$formValues);
        // if(!isset($formValues['fields']) && $type == "update") {
        //     $model->fields()->detach();
        // }
        // if(isset($formValues['fields_id']) && count($formValues['fields_id']) > 0) {
        //     if($type == "update") {
        //         $model->fields()->detach();
        //     }
        //     foreach ($formValues['fields_id'] as $field => $fieldId) {
        //         # code...
        //         $model->fields()->attach((int) $fieldId);
        //     }
        // }
    }
}
