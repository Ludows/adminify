<?php

namespace Ludows\Adminify\Repositories;
use  Ludows\Adminify\Repositories\BaseRepository;

class PageRepository extends BaseRepository
{

    public $internal_relations_columns = [
        'media_id',
    ];

    public $external_relations_columns = [
        'categories_id'
    ];

    public function getExternalCategoriesIdRelationship($model, $formValues, $type) {
        if($formValues['categories_id'] == null && $type == "update") {
            $model->categories()->detach();
        }
        if(isset($formValues['categories_id']) && count($formValues['categories_id']) > 0) {
            if($type == "update") {
                $model->categories()->detach();
            }
            foreach ($formValues['categories_id'] as $cat => $catId) {
                # code...
                $model->categories()->attach((int) $catId);
            }
        }
    }
    
    public function delete($model) {
        $this->hookManager->run('model:deleting', $model);
        $model->categories()->detach();
        $model->deleteUrl([
            'from_model_id' => $model->id
        ]);
        $model->delete();
        $this->hookManager->run('model:deleted', $model);
        $this->hookManager->run('process:finished', $model);
    }
}
