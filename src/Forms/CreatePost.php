<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;
use App\Adminify\Models\Tag;


class CreatePost extends Form
{
    public function buildForm()
    {
        $hydrator = $this->hydrateSelect();
        $hydratorTags = $this->getTags();
        $statuses = $this->getStatuses();
        $enabled_features = get_site_key('enables_features');

        $m = $this->getModel();

            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);
        if(isset($enabled_features['category']) && $enabled_features['category']) {

            $this->add('categories_id', 'select2', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.modal-ajax',
                'modal_attributes' => [
                    'classes' => '',
                    'modalBodyClass' => '',
                    'modalDialogClasses' => '',
                    'modalTitle' => _('admin.modal_title'),
                    'btnSave' => null,
                    'btnClear' => null
                ],
                'form' => [
                    'namespace' => 'App\Adminify\Forms\CreateCategory',
                    'attributes' => [
                        'url' => route('categories.store'),
                        'method' => 'POST'
                    ]
                ],
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
        }
            $this->add('status_id', 'select2', [
                'empty_value' => '',
                'choices' => $statuses['statuses'],
                'selected' => $statuses['selected'],
                'attr' => [],
                'label' => __('admin.form.statuses'),
                'select2options' => [
                    'placeholder' => __('admin.table.modules.statuses.select_status'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ]);
        if(isset($enabled_features['tag']) && $enabled_features['tag']) {

            $this->add('tags_id', 'select2', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.modal-ajax',
                'modal_attributes' => [
                    'classes' => '',
                    'modalBodyClass' => '',
                    'modalDialogClasses' => '',
                    'modalTitle' => _('admin.modal_title'),
                    'btnSave' => null,
                    'btnClear' => null
                ],
                'form' => [
                    'namespace' => 'App\Adminify\Forms\CreateTag',
                    'attributes' => [
                        'url' => route('tags.store'),
                        'method' => 'POST'
                    ]
                ],
                'choices' => $hydratorTags['tags'],
                'selected' => $hydratorTags['selected'],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.tags_id'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_tag'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);
        }   
        if(isset($enabled_features['media']) && $enabled_features['media']) { 
            $this->add('media_id', 'lfm',[
                'label_show' => false,
                'attr' => [
                    'value' => !is_array($m) && $m->media_id != 0 ? $m->media->id : null
                ]
            ]);
        }

            $this->add('content', 'laraberg', [
                'label_show' => false,
                'label' => __('admin.form.content'),
                'withBtnForTemplates' => true
            ]);

            $this->add('no_comments', 'checkbox', [
                'label_show' => true,
                'label' => __('admin.form.no_comments'),
                'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
                'attr' => ['class' => 'custom-control-input'],
                'label_attr' => ['class' => 'custom-control-label text-muted'],
            ]);
            
            $this->add('user_id', 'hidden', [
                'value' => user()->id
            ]);

            $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
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
        $statuses = app('App\Adminify\Models\Statuses')->where('id' , '!=', 3)->pluck('name' ,'id');
        $selecteds = [];

        $statuses = $statuses->all();

        foreach ($statuses as $statusId => $status) {
            # code...
            $statuses[$statusId] = __('admin.table.modules.statuses.'.$status);
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
