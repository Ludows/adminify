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

    // //set as interval for register or update fields objects
    // public $internal_relations_columns = [
    //     'fields'
    // ];

    // public function getFieldsRelationship($model, $formValues, $type) {
    //     dd('internal', $formValues);

    // }


    public function getExternalFieldsRelationship($model, $formValues, $type) {

        if($type == "update") {
            $model->fields()->detach();
        }
        $attachements = [];

        $sampleFormField = new FormField();
        $defaults_attributes = $sampleFormField->getAttributes();

        if(isset($formValues['fields']) && count($formValues['fields']) > 0) {
            foreach ($formValues['fields'] as $fieldKey => $field) {
                # code...

                //remove label
                $keys = array_keys($field);
                $indexKey = array_search('label', $keys);
                $m = new FormField();
                $todoCreate = true;

                if(empty($formValues['fields'][$fieldKey]['label'])) {
                    $field['label'] = 'Field_'.$fieldKey;
                    unset($keys[$indexKey]);
                }

                // enable checking
                foreach ($keys as $key) {
                    # code...
                    if(empty($formValues['fields'][$fieldKey][$key])) {
                        $field[$key] = $defaults_attributes[$key];
                    }
                }

                if(!empty($formValues['fields'][$fieldKey]['fromdb'])) {
                    $todoCreate = false;
                    $m = $m->find((int) $formValues['fields'][$fieldKey]['fromdb']);

                    unset($formValues['fields'][$fieldKey]['fromdb']);
                }


                if($todoCreate) {
                   $field = $this->formFieldRepo->addModel($m)->create($field);
                }
                else {
                    $field = $this->formFieldRepo->addModel($m)->update($field, $m);
                }

                $attachements[] = $field->id;
            }

            if(count($attachements) > 0) {
                $model->fields()->attach($attachements);
            }
        }

    }
}
