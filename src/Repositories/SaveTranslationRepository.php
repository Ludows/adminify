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
    public function update($mixed, $request, $model) {

        $request = request();
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }
        $multilang = $request->useMultilang;


        // dd($formValues);

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

            // dd($trans);

            $model::booted();
            $model->save();

        }
        else {
            $model = Traduction::create($formValues);
        }

        return $model;

    }
}
