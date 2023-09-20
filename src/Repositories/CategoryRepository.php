<?php

namespace Ludows\Adminify\Repositories;

use App\Adminify\Models\Category; // Don't forget to update the model's namespace
use  Ludows\Adminify\Repositories\BaseRepository;
use App\Adminify\Models\Media;
class CategoryRepository extends BaseRepository
{
    // public $internal_relations_columns = [
    //     'media_id',
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

        if($type == "destroy") {
            $check_for_parent_id = Category::where('parent_id', '=', $model->id)->get();
            $childCatArr = $check_for_parent_id->all();
    
            foreach ($childCatArr as $childCat) {
                # code...
                // restore to default
                $childCat->fill(['parent_id' => 0]);
                $childCat->save();
                // $this->hookManager->run('model:updated', $childCat);
            }
        }
    }
}
