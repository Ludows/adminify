<?php

namespace Ludows\Adminify\Repositories;

use App\Models\Category;
use MrAtiebatie\Repository;
use App\Models\Post; // Don't forget to update the model's namespace
use App\Models\Media;
class PostRepository
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
        $this->model = app(Post::class);
    }
    public function create($mixed, $request) {
        // $context is $this of the controller for more flexibility
        $request = request();
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }
        $multilang = $request->useMultilang;

        // dd($formValues);

        if($multilang) {
            $lang = $request->lang;
            $post = new Post();
            $multilangsFields = $post->getMultilangTranslatableSwitch();
            $fields = $post->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $post->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }
            }
            foreach ($fields as $field) {
                if(isset($formValues[$field]) && $field != "categories_id" && $field != "media_id" && $field != "tags_id") {
                    $post->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $post->media_id = $m->id;
                }
                else {
                    $post->media_id = 0;
                }
            }

            $post::booted();

            $post->save();

        }
        else {

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);
            }

            $post = Post::create([
                'title' => $formValues['title'],
                'content' => $formValues['content'],
                'media_id' => $json[0]->name ?? 0
            ]);
        }

        // dd($post->categories());
        if(isset($formValues['categories_id'])) {
            foreach ($formValues['categories_id'] as $catId) {
                # code...
                // dd( $catId);
                $post->categories()->attach((int) $catId, ['post_id' => $post->id]);

            }
        }

        // dd($post->categories());
        if(isset($formValues['tags_id'])) {
            $post->createTags($formValues['tags_id']);
        }

        return $post;
    }
    public function update($mixed, $request, $model) {

        $request = request();
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }
        $multilang = $request->useMultilang;

        // dd($formValues);

        if($multilang) {
            $lang = $request->lang;
            $multilangsFields = $model->getMultilangTranslatableSwitch();
            $fields = $model->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $model->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field]) && $field != "categories_id" && $field != "media_id" && $field != "tags_id") {
                    $model->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $model->media_id = $m->id;
                }
                else {
                    $model->media_id = 0;
                }
            }
        }


        if(isset($formValues['categories_id'])) {
            $insertedCategories = $model->categories;

            if(count($insertedCategories) > 0) {
                // On detache puis on réattache pour éviter les doublons
                $model->categories()->detach();
            }

            foreach ($formValues['categories_id'] as $catId) {
                $model->categories()->attach((int) $catId);
            }

        }

        if(isset($formValues['tags_id'])) {
            $model->updateTags($formValues['tags_id']);
        }

        if($multilang) {
            $model::booted();
        }
        else {
            unset($formValues['categories_id']);
            $model->fill($formValues);
        }

        $model->save();

        return $model;
    }
    public function delete($model) {

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
    }
}
