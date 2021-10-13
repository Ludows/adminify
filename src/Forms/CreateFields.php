<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
class CreateFields extends Form
{
    public function buildForm()
    {
        $this->add('label', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.label')
            ]
        ]);

        $this->add('required', 'hidden', [
            'value' => 0
        ])
        ->add('required', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.formbuilder.required'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        ->add('max_length', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.max_length')
            ]
        ])
        ->add('label_show', 'hidden', [
            'value' => 0
        ])
        ->add('label_show', 'checkbox', [
            'label_show' => true,
            'label' => __('admin.formbuilder.label_show'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ])
        ->add('label_attr', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.label_attr')
            ]
        ])
        ->add('attr', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.attr')
            ]
        ])
        ->add('wrapper', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.wrapper')
            ]
        ]);
    }
}
