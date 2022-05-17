<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Adminify\Models\Seo; // Don't forget to update the model's namespace
use App\Adminify\Models\Media;
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
        // $this->hookManager->run('process:finished', $model);
    }
    public function process($formValues, $lang, $multilang, $model) {

        foreach ($formValues as $key => $value) {
            # code...
            $hooks = ['seo:creating', 'seo:created'];
            $hasSeo = $model->seoWith($key);
            if($hasSeo != null) {
                $hooks = ['seo:updating', 'seo:updated'];
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
            // $this->hookManager->run($hooks[0], $seo);
            $seo->save();
            // $this->hookManager->run($hooks[1], $seo);
        }

    }
}
