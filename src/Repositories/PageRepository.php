<?php

namespace Ludows\Adminify\Repositories;
use  Ludows\Adminify\Repositories\BaseRepository;
use App\Adminify\Models\Media;

class PageRepository extends BaseRepository
{

    // public $internal_relations_columns = [
    //     'media_id',
    // ];

    // public $external_relations_columns = [
    //     'categories_id'
    // ];

    public function beforeRun($model, $formValues, $type) {
        if(isset($formValues['media_id']) && $formValues['media_id'] != 0 && $type != "destroy") {
            $id = (int) $formValues['media_id'];

            $m = Media::where('id', $id)->first();
            if($m != null) {
                $model->media_id = $m->id;
            }
            else {
                $model->media_id = 0;
            }
        }

        if($type == 'destroy') {
            $model->categories()->detach();
            $model->deleteUrl([
                'from_model_id' => $model->id
            ]);
        }
    }

    public function afterRun($model, $formValues, $type) {
        if($type != "create") {
            $model->categories()->detach();
        }

        if(isset($formValues['categories']) && count($formValues['categories']) > 0) {
            foreach ($formValues['categories'] as $cat => $catId) {
                # code...
                $model->categories()->attach((int) $catId);
            }
        }
    }
}
