<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;
use App\Adminify\Models\Page;

class CreatePage extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $hydratorPages = $this->hydrateSelectPage();
        $enabled_features = $this->getFeaturesSite();
        // $translations = $m->translations;

        $this
            ->add('title', Field::TEXT, [
                'label_show' => false,
                'attr' => ['placeholder' =>  __('admin.form.title') ],
            ]);
        if(isset($enabled_features['category']) && $enabled_features['category']) {

            $this->addCategories('categories', [
                'empty_value' => '',
                'withCreate' => true,
                'modal' => 'adminify::layouts.admin.modales.modal-ajax', // simple include,
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
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.categories_id'),
                'select2options' => [
                    'placeholder' => __('admin.select_category'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);
        }
        $this->addStatuses('status_id', [
            'empty_value' => '',
            'attr' => [],
            'label' => __('admin.form.statuses'),
            'select2options' => [
                'placeholder' => __('admin.table.modules.statuses.select_status'),
                'multiple' => false,
                'width' => '100%'
            ]
            ]);
            
            $this->addPages('parent_id', [
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
            ]);
            if(isset($enabled_features['media']) && $enabled_features['media']) {
                $this->addMediaLibraryPicker('media_id');
            }

            $this->addVisualEditor('content', [
                'label_show' => false,
            ]);
            
            $this->addUserId('user_id', []);
            $this->addSubmit();      
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

        if(isset($hasModel->parent) && count($hasModel->parent->all()) > 0) {
            // on a une selection
            $selecteds = $hasModel->parent()->get()->pluck('id')->all();
        }

        return [ 'pages' => $pages->all(), 'selected' => $selecteds];
    }
}
