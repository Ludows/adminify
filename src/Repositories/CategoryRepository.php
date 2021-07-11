<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Category; // Don't forget to update the model's namespace

use App\Models\Media;

class CategoryRepository
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
        $this->model = app(Category::class);
    }
    public function create($mixed, $request) {

        $request = request();
        if(is_array($mixed)) {
            $formValues = $mixed;
        }
        else {
            $formValues = $mixed->getFieldValues();
        }
        $multilang = $request->useMultilang;

        if($multilang) {
            $lang = $request->lang;
            $category = new Category();
            $multilangsFields = $category->getMultilangTranslatableSwitch();
            $fields = $category->getFieldsExceptTranslatables();
            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $category->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $category->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $category->media_id = $m->id;
                }
            }
            // call boot method to save slug
            $category::booted();

            $category->save();

        }
        else {
            // create entity
            $category = Category::create($formValues);
        }




        return $category;
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

        if($multilang) {
            $lang = $request->lang;

            $multilangsFields = $model->getMultilangTranslatableSwitch();
            $fields = $model->getFieldsExceptTranslatables();
            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $model->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field])) {
                    $model->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $model->media_id = $m->id;
                }
            }
            // call boot method to save slug
            $model::booted();
        }
        else {
            $model->fill($formValues);
        }

        $model->save();
    }
    public function delete($model) {

        $check_for_parent_id = Category::where('parent_id', '=', $model->id)->get();
        $childCatArr = $check_for_parent_id->all();

        foreach ($childCatArr as $childCat) {
            # code...
            // restore to default
            $childCat->fill(['parent_id' => 0]);
            $childCat->save();
        }

        $model->delete();
    }
}
