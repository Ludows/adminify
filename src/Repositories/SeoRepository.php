<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Seo; // Don't forget to update the model's namespace

use Illuminate\Support\Arr;

class SeoRepository
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
        $this->model = app(Seo::class);
    }
    public function findOrCreate($model, $form) {
        $request = request();
        $formValues = $form->getFieldValues(false);
        $multilang = $request->useMultilang;
        $lang = $request->lang;


        $formValues = Arr::where($formValues, function ($value, $key) {
            return $key != '_seo';
        });


        $this->process($formValues, $lang, $multilang, $model);
    }
    public function process($formValues, $lang, $multilang, $model) {

        foreach ($formValues as $key => $value) {
            # code...
            $hasSeo = $model->seoWith($key);
            if($hasSeo != null) {
                $seo = $hasSeo;
            }
            else {
                $seo = new Seo();
            }
            $seo->type = $key;
            $seo->model_name = $model->getNameSpace();
            $seo->model_id = $model->id;
            if($multilang) {
                $seo->setTranslation('data', $lang, $value);
            }
            else {
                $seo->data = $value;
            }

            if(isset($formValues['image']) && $key == "image") {
                $json = json_decode($formValues['image']);
                $seo->setTranslation('data', $lang, $json[0]->name);
            }

            $seo->save();
        }

    }
}
