<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Tag; // Don't forget to update the model's namespace


class TagRepository
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
        $this->model = app(Tag::class);
    }
    public function create($mixed, $request) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $request = request();
        $multilang = $request->useMultilang;

        // dd($formValues);

        if($multilang) {
            $lang = $request->lang;
            $tag = new Tag();
            $multilangsFields = $tag->getMultilangTranslatableSwitch();
            $fields = $tag->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $tag->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $tag->{$field} = $formValues[$field];
                }
            }

            $tag::booted();

            $tag->save();

        }
        else {
            //@todo
            if(isset($formValues['media_id']) && $formValues['media_id'] != 0) {
                $json = json_decode($formValues['media_id']);
            }
            $tag = Tag::create([
                'title' => $formValues['title'],
                'content' => $formValues['content'],
                'media_id' => isset($formValues['media_id']) && $formValues['media_id'] != 0 ? $json[0]->name : 0,
                'parent_id' => isset($formValues['parent_id']) ? $formValues['parent_id'] : 0
            ]);
        }

        return $tag;
    }
    public function update($mixed, $request, $tag) {

        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }

        $request = request();
        $multilang = $request->useMultilang;

        // dd($formValues);

        if($multilang) {
            $lang = $request->lang;
            $multilangsFields = $tag->getMultilangTranslatableSwitch();
            $fields = $tag->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $tag->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field]) && $field != "categories_id" && $field != "media_id") {
                    $tag->{$field} = $formValues[$field];
                }
            }

            $tag::booted();
            $tag->save();

        }
        else {
           
            //@todo
            $tag->fill([
                'title' => $formValues['title'],
                'content' => $formValues['content'],
                'parent_id' => isset($formValues['parent_id']) ? $formValues['parent_id'] : 0
            ]);
        }

        return $tag;
    }
    public function delete($model) {
        $model->delete();
    }
}
