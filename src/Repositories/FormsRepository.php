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
        $is_multilang = is_multilang();

        //dd($formValues);

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

                if(!empty($formValues['fields'][$fieldKey]['choices'])) {
                    $choicesOptions = array();
                    $selectedsOptions = array();
                    $multilignes = explode(',', $formValues['fields'][$fieldKey]['choices']);
                    $multilignes_selecteds = explode(',', $formValues['fields'][$fieldKey]['selected']);

                    $base_iterator = 0;
                    foreach ($multilignes as $multiligne) {
                        # code...
                        $multilignes = explode(':', $multiligne);

                        if(count($multilignes) > 1) {
                            $choicesOptions[trim($multilignes[0])] = trim($multilignes[1]);
                        }
                        if(count($multilignes_selecteds) > 0 && count($multilignes) > 1 && $multilignes_selecteds[0] == $multilignes[0]) {
                            $selectedsOptions[trim($multilignes[0])] = trim($multilignes[1]);
                        }
                        $base_iterator++;
                    }

                    $field['choices'] = json_encode($choicesOptions);
                    $field['selected'] = json_encode($multilignes_selecteds);
                }

                if(!empty($formValues['fields'][$fieldKey]['fromdb'])) {
                    $todoCreate = false;
                    $m = $m->find((int) $formValues['fields'][$fieldKey]['fromdb']);
                }
                unset($formValues['fields'][$fieldKey]['fromdb']);

                // enable checking
                foreach ($keys as $key) {
                    # code...
                    if(isset($defaults_attributes[$key]) && empty($formValues['fields'][$fieldKey][$key])) {
                        $field[$key] = $defaults_attributes[$key];
                    }
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
                $model->fields()->syncWithoutDetaching($attachements);
            }
        }

    }
}
