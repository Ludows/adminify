<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Mailables; // Don't forget to update the model's namespace
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;



class MailsRepository
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
        $this->model = app(Mailables::class);
    }
    public function create($mixed, $request) {
        // $context is $this of the controller for more flexibility
        // dd($context, $request);
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $r = request();
        $multilang = $r->useMultilang;
        $m = new Mailables();

        if($multilang) {
            $lang = $request->lang;
            
            $multilangsFields = $m->getMultilangTranslatableSwitch();
            $fields = $m->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $m->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $m->{$field} = $formValues[$field];
                }
            }

            $m::booted();
        }

        $m->save();

        // // create entity
        // $media = Media::create($formValues);

        return $m;
    }
    public function update($mixed, $request, $model) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $r = request();
        $multilang = $r->useMultilang;
        $m = $model;

        if($multilang) {
            $lang = $request->lang;
            
            $multilangsFields = $m->getMultilangTranslatableSwitch();
            $fields = $m->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $m->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $m->{$field} = $formValues[$field];
                }
            }

            $m::booted();
        }

        $m->save();
    }
    public function delete($model) {
        $model->delete();
    }
}
