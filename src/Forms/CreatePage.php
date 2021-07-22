<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Models\Category;
use App\Models\Page;

class CreatePage extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $hydratorCat = $this->hydrateSelect();
        $hydratorPages = $this->hydrateSelectPage();
        $m = $this->getModel();
        $r = $this->getRequest();
        $statuses = $this->getStatuses();
        // $translations = $m->translations;

        $this
            ->add('title', Field::TEXT, [
                'label_show' => false,
                'attr' => ['placeholder' =>  __('admin.title') ],
            ])
            ->add('categories_id', 'select2', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.createCategory', // simple include
                'choices' => $hydratorCat['categories'],
                'selected' => $hydratorCat['selected'],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.categories_id'),
                'select2options' => [
                    'placeholder' => __('admin.select_category'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ])
            ->add('status_id', 'select2', [
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
            ])
            ->add('parent_id', 'select2', [
                'empty_value' => '',
                'choices' => $hydratorPages['pages'],
                'selected' => $hydratorPages['selected'],
                'attr' => [],
                'label' => __('admin.form.parent_id'),
                'label_attr' => ['class' => 'control-label', 'for' => 'post_parent_id'],
                'select2options' => [
                    'placeholder' => __('admin.select_parentpage_id'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('media_id', 'lfm', [
                'label_show' => false,
                'attr' => [
                    'value' => !is_array($m) && $m->media_id != 0 ? $m->media->path : null
                ]
            ])
            ->add('content', 'laraberg', [
                'label_show' => false
            ])   
            ->add('user_id', 'hidden', [
                'value' => user()->id
            ])       
            ->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
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
    public function hydrateSelectPage() {
        $pages = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $pages = Page::get()->pluck('title' ,'id');
        $selecteds = '';

        if(isset($hasModel->childrens) && count($hasModel->childrens->all()) > 0) {
            // on a une selection
            $selecteds = $hasModel->childrens()->get()->pluck('id')->all();
        }

        return [ 'pages' => $pages->all(), 'selected' => $selecteds];
    }
}
