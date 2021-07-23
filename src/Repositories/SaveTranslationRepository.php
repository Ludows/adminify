<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;

class SaveTranslationRepository
{
    use Repository;

    /**
     * The model being queried.
     *
     * @var Model
     */
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {}
    public function update($mixed, $model) {

        $request = request();
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }
        $multilang = $request->useMultilang;

        $excludes = [
            '_method',
            '_token',
            'from',
            'current_lang',
            'type',
            'id'
        ];

        foreach ($formValues as $key => $value) {
            # code...
            if(in_array($key, $excludes)) {
                unset($formValues[$key]);
            }
        }

        if($multilang) {
            $lang = $request->lang;
            $multilangsFields = $model->getMultilangTranslatableSwitch();
            $fields = $model->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $model->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $model->{$field} = $formValues[$field];
                }
            }

        }

        $model::booted();
        $model->save();

        return $model;

    }
}
