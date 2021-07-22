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
        $statuses = $this->getStatuses();

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
            $this->add('status_id', 'select2', [
                'empty_value' => '',
                'choices' => $statuses['statuses'],
                'selected' => $statuses['selected'],
                'attr' => [],
                'label' => __('admin.form.statuses'),
                'select2options' => [
                    'placeholder' => __('admin.statuses'),
                    'multiple' => false,
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

            $this->add('no_comments', 'checkbox', [
                'label_show' => true,
                'label' => __('admin.form.no_comments'),
            ]);
            
            $this->add('user_id', 'hidden', [
                'value' => user()->id
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
    public function getStatuses() {
        $hasModel = $this->getModel();
        $statuses = app('App\Models\Statuses')->all()->pluck('name' ,'id');
        $selecteds = [];

        $statuses = $statuses->all();

        foreach ($statuses as $statusId => $status) {
            # code...
            $statuses[$statusId] = __('admin.statuses.'.$status);
        }

        if(isset($hasModel->status)) {
            // on a une selection
            $selecteds = $hasModel->status()->get()->pluck('id')->all();
        }

        return [ 'statuses' => $statuses, 'selected' => $selecteds];
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
