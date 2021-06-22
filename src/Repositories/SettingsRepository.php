<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Ludows\Adminify\Models\Settings; // Don't forget to update the model's namespace

class SettingsRepository
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
        $this->model = app(Settings::class);
    }
    public function CreateOrUpdate($form, $request) {
        $request = request();
        $formValues = $form->getFieldValues(true);
        $multilang = $request->useMultilang;
        if($multilang) {
            $lang = $request->lang;

            foreach ($formValues as $key => $value) {
                # code...
                $check = Settings::where('type', $key)->first();
                $model = null;

                if($check != null) {
                    $model = $check;
                }
                else {
                    $model = new Settings();
                }

                $model->type = $key;
                $model->setTranslation('data', $lang, $value);
                if($check != null) {
                    // if($model->type == 'homepage') {
                    //     dd($model);
                    // }
                    $model->fill([
                        'type' => $model->type,
                        'data' => $model->data
                    ]);

                    $model->save();
                }
                else {
                    $model->save();
                }

            }


        }
        else {

            foreach ($formValues as $key => $value) {
                # code...
                $check = Settings::where('type', $key)->first();
                $model = null;

                if($check != null) {
                    $model = $check;
                }
                else {
                    $model = new Settings();
                }

                $model->type = $key;
                $model->data = $value;

                if($check != null) {
                    $model->fresh();
                    $model->fill([
                        'type' => $model->type,
                        'data' => $model->data
                    ]);
                }
                else {
                    $model->save();
                }
            }

        }

        return $model;
    }
}
