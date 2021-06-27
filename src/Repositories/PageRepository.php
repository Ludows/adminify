<?php

namespace Ludows\Adminify\Repositories;

use MrAtiebatie\Repository;
use Ludows\Adminify\Models\Page; // Don't forget to update the model's namespace
use Ludows\Adminify\Models\Media;


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
    public function create($form, $request) {

        $formValues = $form->getFieldValues(true);

        $request = request();
        $formValues = $form->getFieldValues();
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

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $page->media_id = $m->id;
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

        return $page;
    }
    public function update($form, $request, $page) {
        $formValues = $form->getFieldValues(true);

        $request = request();
        $formValues = $form->getFieldValues();
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

            if(isset($formValues['media_id'])) {
                $json = json_decode($formValues['media_id']);

                $m = Media::where('src', $json[0]->name)->first();
                if($m != null) {
                    $page->media_id = $m->id;
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

        return $page;
    }
    public function delete($model) {
        $model->categories()->detach();
        $model->delete();
    }
}
