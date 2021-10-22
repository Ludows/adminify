<?php

namespace Ludows\Adminify\Repositories;

use  Ludows\Adminify\Repositories\BaseRepository;
use App\Adminify\Models\FormField;
use App\Adminify\Repositories\FormFieldsRepository;

class FormsRepository extends BaseRepository
{
    private $formFieldRepo;
    public function __construct(FormFieldsRepository $formFieldRepo) {
        parent::__construct();
        $this->formFieldRepo = $formFieldRepo;
    }
    // set for only linking to pivot table
    public $external_relations_columns = [
        'fields'
    ];

    //set as interval for register or update fields objects
    public $internal_relations_columns = [
        'fields'
    ];

    // public function getFieldsRelationship($model, $formValues, $type) {
    //     dd('internal', $formValues);
        
    // }


    public function getExternalFieldsRelationship($model, $formValues, $type) {
        dd('external',$formValues);
        if(!isset($formValues['fields']) && $type == "update") {
            $model->detach();
        }
        $attachements = [];

        if(isset($formValues['fields']) && count($formValues['fields']) > 0) {
            foreach ($formValues['fields'] as $fieldKey => $field) {
                # code...
                if($type == "create") {
                   $field = $this->formFieldRepo->addModel(new FormField())->create($field);
                   $attachements[$model->id] = ['field_id' => $field->id];
                }
                else {
                    dd('todo update');
                    $this->formFieldRepo->addModel(new FormField())->update($field, new FormField());
                }
            }

            if(count($attachements) > 0) {
                $model->attach($attachements);
            }
        }
        
    }
}
