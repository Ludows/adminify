<?php

namespace Ludows\Adminify\Repositories;

use App\Adminify\Models\Media;
use  Ludows\Adminify\Repositories\BaseRepository;
class PostRepository extends BaseRepository
{

    // public $internal_relations_columns = [
    //     'media_id',
    // ];

    // public $external_relations_columns = [
    //     'tags_id',
    //     'categories_id'
    // ];

    public function afterRun($model, $formValues, $type) {
        if($type == 'update') {
            $model->deleteTags($model->id);
        }

        if(isset($formValues['tags'])) {
            $model->setTags($model->id, $formValues['tags']);
        }   

        if($type != "create") {
            $model->deleteCategories($model->id);
            // $model->categories()->detach();
        }

        if(isset($formValues['categories'])) {
            $model->updateCategories($model->id, $formValues['categories']);
            // foreach ($formValues['categories'] as $catId) {
            //     $model->categories()->attach((int) $catId);
            // }
        
        }
    }
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
            // $this->hookManager->run('model:deleting', $model);
            $insertedCategories = $model->getCategories($model->id);
            $insertedTags = $model->getTags($model->id);

            if(count($insertedCategories) > 0) {
                // On detache puis on réattache pour éviter les doublons
                $model->deleteCategories($model->id);
                // $model->categories()->detach();
            }
            if(count($insertedTags) > 0) {
                $model->deleteTags();
            }

            $model->deleteUrl([
                'from_model_id' => $model->id
            ]);
        }
    }
    
    // public function getExternalTagsIdRelationship($model,$formValues, $type) {
    //     if($type == 'update') {
    //         $model->deleteTags(null);
    //     }

    //     if(isset($formValues['tags_id'])) {
    //         $model->createTags($formValues['tags_id']);
    //     }        
    // }
    // public function getExternalCategoriesIdRelationship($model , $formValues, $type) {
    //     if(!isset($formValues['categories_id']) && $type == "update") {
    //         $model->categories()->detach();
    //     }
    //     if(isset($formValues['categories_id'])) {
    //         if($type == 'update') {
    //             $insertedCategories = $model->categories;
        
    //             if(count($insertedCategories) > 0) {
    //                 // On detache puis on réattache pour éviter les doublons
    //                 $model->categories()->detach();
    //             }
    //         }
            
        
    //         foreach ($formValues['categories_id'] as $catId) {
    //             $model->categories()->attach((int) $catId);
    //         }
        
    //     }
    // }
}
