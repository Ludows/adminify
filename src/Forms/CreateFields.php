<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
class CreateFields extends Form
{
    public function buildForm()
    {

        $this->add('field_type', 'hidden', [
            'attr' => [
                'value' => '__TYPEDFORM__'
            ]
        ]);

        $this->add('multiple', 'hidden', [
            'attr' => [
                'value' => 0
            ]
        ]);

        $this->add('expanded', 'hidden', [
            'attr' => [
                'value' => 0
            ]
        ]);

        $this->add('selected', 'select', [

        ]);

        $this->add('default_value', 'text', [
            'label' => __('adminify.formbuilder.default_value'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.default_value')
            ]
        ]);

        $this->add('value', 'text', [
            'label' => __('adminify.formbuilder.value'),
            'attr' => [
                'class' => 'js-value form-control',
                'placeholder' => __('adminify.formbuilder.value')
            ]
        ]);

        $this->add('choices', 'textarea', [
            'label' => __('adminify.formbuilder.choices'),
            'attr' => [
                'class' => 'js-choices form-control',
                'placeholder' => __('adminify.formbuilder.choices')
            ]
        ]);

        $this->add('content', 'summernote', [
            'label' => __('adminify.formbuilder.content'),
            'force_js' => true,
            'force_sibling' => true,
            'sibling' => 'content___FUNCTIONAL__',
            'attr' => [
                'data-functional' => '__FUNCTIONAL__',
                'data-replace' => 'fields[__REPLACE__][content]',
                'class' => 'form-control',
                'placeholder' => __('adminify.formbuilder.content')
            ]
        ]);

        $this->add('label', 'text', [
            'label' => __('adminify.formbuilder.label'),
            'attr' => [
                'class' => 'form-control js-labelize',
                'placeholder' => __('adminify.formbuilder.label')
            ]
        ]);

        $this->add('required', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.formbuilder.required'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input js-check-required'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        ->add('checked', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.formbuilder.checked'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input js-check-checked'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        ->add('max_length', 'number', [
            'label' => __('adminify.formbuilder.max_length'),
            'attr' => [
                'minlength' => 0,
                'class' => 'form-control js-max-length',
                'placeholder' => __('adminify.formbuilder.max_length')
            ]
        ])
        // ->add('label_show', 'hidden', [
        //     'value' => 0
        // ])
        ->add('label_show', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.formbuilder.label_show'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input js-show-label'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        ->add('custom_error_message', 'text', [
            'label' => __('adminify.formbuilder.custom_error_message'),
            'attr' => [
                'class' => 'form-control js-error-message',
                'placeholder' => __('adminify.formbuilder.custom_error_message')
            ]
        ])
        ->add('label_attr', 'textarea', [
            'label' => __('adminify.formbuilder.label_attr'),
            'attr' => [
                'class' => 'form-control js-attrs',
                'data-location' => 'label',
                'placeholder' => __('adminify.formbuilder.label_attr')
            ]
        ])
        ->add('attr', 'textarea', [
            'label' => __('adminify.formbuilder.attr'),
            'attr' => [
                'class' => 'form-control js-attrs',
                'placeholder' => __('adminify.formbuilder.attr')
            ]
        ])
        ->add('wrapper', 'textarea', [
            'label' => __('adminify.formbuilder.wrapper'),
            'attr' => [
                'class' => 'form-control js-attrs',
                'data-location' => '.form-group',
                'placeholder' => __('adminify.formbuilder.wrapper')
            ]
        ]);
    }
}
