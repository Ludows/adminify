<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use App\Models\Page; // Don't forget to update the model's namespace
use App\Models\Media;


class PageRepository
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
        $this->model = app(Page::class);
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
            $page = new Page();
            $multilangsFields = $page->getMultilangTranslatableSwitch();
            $fields = $page->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $page->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field]) && $field != "categories_id" && $field != "media_id") {
                    $page->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id']) && $formValues['media_id'] != 0) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $page->media_id = $m->id;
                }
                else {
                    $page->media_id = 0;
                }
            }

            $page::booted();

            $page->save();

        }
        else {
            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);
            }
            $page = Page::create([
                'title' => $formValues['title'],
                'content' => $formValues['content'],
                'media_id' => isset($formValues['media_id']) ? $json[0]->name : 0,
                'parent_id' => isset($formValues['parent_id']) ? $formValues['parent_id'] : 0
            ]);
        }

        if(isset($formValues['categories_id']) && count($formValues['categories_id']) > 0) {
            foreach ($formValues['categories_id'] as $cat => $catId) {
                # code...
                $page->categories()->attach((int) $catId);
            }
        }
        // store if parent is present
        if(isset($formValues['parent_id']) && $formValues['parent_id'] != 0) {
            $page->syncUrl([
                'model_id' => $formValues['parent_id'],
                'model_name' => '\App\Models\Page',
                'order' => 0
            ]);
        }
        // store the current page
        $page->syncUrl([
            'order' => 1
        ]);

        return $page;
    }
    public function update($mixed, $request, $page) {

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
            $multilangsFields = $page->getMultilangTranslatableSwitch();
            $fields = $page->getFieldsExceptTranslatables();
            // dd($fields);

            foreach ($multilangsFields as $multilangsField) {
                # code...
                if(isset($formValues[$multilangsField])) {
                    $page->setTranslation($multilangsField, $lang, $formValues[$multilangsField]);
                    unset($formValues[$multilangsField]);
                }

            }
            foreach ($fields as $field) {
                if(isset($formValues[$field]) && $field != "categories_id" && $field != "media_id") {
                    $page->{$field} = $formValues[$field];
                }
            }

            if(isset($formValues['media_id']) && $formValues['media_id'] != 0) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $page->media_id = $m->id;
                }
                else {
                    $page->media_id = 0;
                }
            }

            $page::booted();
            $page->save();

        }
        else {
            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);
            }
            $page->fill([
                'title' => $formValues['title'],
                'content' => $formValues['content'],
                'media_id' => isset($formValues['media_id']) ? $json[0]->name : 0,
                'parent_id' => isset($formValues['parent_id']) ? $formValues['parent_id'] : 0
            ]);
        }

        if(isset($formValues['categories_id']) && count($formValues['categories_id']) > 0) {
            $page->categories()->detach();
            foreach ($formValues['categories_id'] as $cat => $catId) {
                # code...
                $page->categories()->attach((int) $catId);
            }
        }
        // store if parent is present
        if(isset($formValues['parent_id']) && $formValues['parent_id'] != 0) {
            $page->syncUrl([
                'model_id' => $formValues['parent_id'],
                'model_name' => '\App\Models\Page',
                'order' => 0
            ]);
        }
        // store the current page
        $page->syncUrl([
            'order' => 1
        ]);

        return $page;
    }
    public function delete($model) {
        $model->categories()->detach();
        $model->deleteUrl([
            'from_model_id' => $model->id
        ]);
        $model->delete();
    }
}
