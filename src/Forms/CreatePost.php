<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Models\Category;
use App\Models\Tag;


class CreatePost extends Form
{
    public function buildForm()
    {
        $hydrator = $this->hydrateSelect();
        $hydratorTags = $this->getTags();

        $m = $this->getModel();

            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);
            $this->add('categories_id', 'select2', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.createCategory',
                'choices' => $hydrator['categories'],
                'selected' => $hydrator['selected'],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.categories_id'),
                'select2options' => [
                    'placeholder' => __('admin.select_category'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);

            $this->add('tags_id', 'select2', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.createTag',
                'choices' => $hydratorTags['tags'],
                'selected' => $hydratorTags['selected'],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.tags_id'),
                'select2options' => [
                    'placeholder' => __('admin.select_tag'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);
            
            $this->add('media_id', 'lfm',[
                'label_show' => false,
                'attr' => [
                    'value' => !is_array($m) && $m->media_id != 0 ? $m->media->path : null
                ]
            ]);

            $this->add('content', 'laraberg', [
                'label' => __('admin.form.content'),
            ]);
            
            $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }

    public function getTags() {
        $hasModel = $this->getModel();
        $tags = Tag::get()->pluck('title' ,'id');
        $selecteds = '';

        if(isset($hasModel->tags) && count($hasModel->tags->all()) > 0) {
            // on a une selection
            $selecteds = $hasModel->tags()->get()->pluck('id')->all();
        }

        return [ 'tags' => $tags->all(), 'selected' => $selecteds];
    }

    public function hydrateSelect() {
        $categories = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $categories = Category::get()->pluck('title' ,'id');
        $selecteds = '';

        if(isset($hasModel->categories) && count($hasModel->categories->all()) > 0) {
            // on a une selection
            $selecteds = $hasModel->categories()->get()->pluck('id')->all();

            // $selecteds = $selecteds->all();
        }

        return [ 'categories' => $categories->all(), 'selected' => $selecteds];
    }
}
