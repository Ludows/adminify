<?php

namespace Ludows\Adminify\Repositories;

use App\Models\Category; // Don't forget to update the model's namespace
use  Ludows\Adminify\Repositories\BaseRepository;
class CategoryRepository extends BaseRepository
{
    public $relations_columns = [
        'media_id',
    ];

    public function delete($model) {
        $this->hookManager->run('model:deleting', $model);

        $check_for_parent_id = Category::where('parent_id', '=', $model->id)->get();
        $childCatArr = $check_for_parent_id->all();

        foreach ($childCatArr as $childCat) {
            # code...
            // restore to default
            $childCat->fill(['parent_id' => 0]);
            $childCat->save();
        }

        $model->delete();
        $this->hookManager->run('model:deleted', $model);

    }
}
