<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
class CreateFields extends Form
{
    public function buildForm()
    {
        $this->add('default_value', 'text', [
            'label' => __('adminify.formbuilder.default_value'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.default_value')
            ]
        ]);

        $this->add('choices', 'textarea', [
            'label' => __('adminify.formbuilder.choices'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.choices')
            ]
        ]);

        $this->add('label', 'text', [
            'required' => true,
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
        ->add('max_length', 'number', [
            'label' => __('adminify.formbuilder.max_length'),
            'attr' => [
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
                'placeholder' => __('adminify.formbuilder.custom_error_message')
            ]
        ])
        ->add('label_attr', 'textarea', [
            'label' => __('adminify.formbuilder.label_attr'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.label_attr')
            ]
        ])
        ->add('attr', 'textarea', [
            'label' => __('adminify.formbuilder.attr'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.attr')
            ]
        ])
        ->add('wrapper', 'textarea', [
            'label' => __('adminify.formbuilder.wrapper'),
            'attr' => [
                'placeholder' => __('adminify.formbuilder.wrapper')
            ]
        ]);
    }
}
