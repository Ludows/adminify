<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;


class CreatePost extends BaseForm
{
    public function buildForm()
    {
        $enabled_features = $this->getFeaturesSite();


            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);
        if(isset($enabled_features['category']) && $enabled_features['category']) {

            $this->addCategories('categories', [
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
                        'url' => route('admin.categories.store'),
                        'method' => 'POST'
                    ]
                ],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.categories_id'),
                'select2options' => [
                    'placeholderValue' => __('admin.select_category'),
                ]
            ]);
        }
            $this->addStatuses('status_id', [
                'empty_value' => '',
                'attr' => [],
                'label' => __('admin.form.statuses'),
                'select2options' => [
                    'placeholderValue' => __('admin.table.modules.statuses.select_status'),
                ]
            ]);
        if(isset($enabled_features['tag']) && $enabled_features['tag']) {

            $this->addTags('tags', [
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
                        'url' => route('admin.tags.store'),
                        'method' => 'POST'
                    ]
                ],
                // 'choices' => $hydratorTags['tags'],
                // 'selected' => $hydratorTags['selected'],
                'attr' => ['multiple' => 'multiple'],
                'label' => __('admin.form.tags_id'),
                'select2options' => [
                    'placeholderValue' => __('admin.form.select_tag'),
                ]
            ]);
        }   
        if(isset($enabled_features['media']) && $enabled_features['media']) { 
            $this->addMediaLibraryPicker('media_id');
        }

        $this->addVisualEditor('content', [
            'label_show' => false,
            'label' => __('admin.form.content'),
        ]);

        $this->addUserId();
        $this->addSubmit();

    }
}
