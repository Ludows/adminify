<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Seo; // Don't forget to update the model's namespace
use App\Models\Media;
use Illuminate\Support\Arr;

use  Ludows\Adminify\Repositories\BaseRepository;
class SeoRepository extends BaseRepository
{
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

            $r = new \ReflectionClass($model);

            $seo->model_name = $r->name;
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
