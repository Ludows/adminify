<?php

namespace Ludows\Adminify\Repositories;

use App\Models\Media;
use  Ludows\Adminify\Repositories\BaseRepository;
class PostRepository extends BaseRepository
{

    public $relations_columns = [
        'media_id',
        'tags_id',
        'categories_id'
    ];
    
    public function getTagIdRelationship($model,$formValues, $type) {
        if(isset($formValues['tags_id'])) {
            $model->createTags($formValues['tags_id']);
        }
    }
    public function getCategoriesIdRelationship($model , $formValues, $type) {
        if(isset($formValues['categories_id'])) {
            if($type == 'update') {
                $insertedCategories = $model->categories;
        
                if(count($insertedCategories) > 0) {
                    // On detache puis on réattache pour éviter les doublons
                    $model->categories()->detach();
                }
            }
            
        
            foreach ($formValues['categories_id'] as $catId) {
                $model->categories()->attach((int) $catId);
            }
        
        }
    }
    public function delete($model) {

        $this->hookManager->run('model:deleting', $model);
        $insertedCategories = $model->categories;
        $insertedTags = $model->tags;

        if(count($insertedCategories) > 0) {
            // On detache puis on réattache pour éviter les doublons
            $model->categories()->detach();
        }
        if(count($insertedTags) > 0) {
            $model->deleteTags();
        }
        $model->delete();
        $this->hookManager->run('model:deleted', $model);
    }
}
