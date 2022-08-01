<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;
use App\Adminify\Models\Tag;


class CreatePost extends BaseForm
{
    public function buildForm()
    {
        $enabled_features = $this->getFeaturesSite();


            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);
        if(isset($enabled_features['category']) && $enabled_features['category']) {

            $this->addCategories('categories_id', [
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
        if(isset($enabled_features['tag']) && $enabled_features['tag']) {

            $this->addTags('tags_id', [
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
                // 'choices' => $hydratorTags['tags'],
                // 'selected' => $hydratorTags['selected'],
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
