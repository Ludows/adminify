<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Translations as Traduction; // Don't forget to update the model's namespace

class TranslationRepository
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
    {
        // Don't forget to update the model's name
        $this->model = app(Traduction::class);
    }
    public function create($mixed, $request) {
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
            $trans = new Traduction();
            $multilangsFields = $trans->getMultilangTranslatableSwitch();
            $fields = $trans->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $trans->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $trans->{$field} = $formValues[$field];
                }
            }

            // dd($trans);

            $trans::booted();
            $trans->save();

        }
        else {
            $trans = Traduction::create($formValues);
        }

        return $trans;
    }
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
    public function delete($model) {
        $model->delete();
    }
}
