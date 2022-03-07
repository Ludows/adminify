<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;

class ConditionnalShowMetas extends Form
{
    public function buildForm()
    {
         $this->add('typed_data', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [
                    'class' => 'form-control js-typed-data'
                ],
                'label' => __('admin.form.named_metas'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_named_metas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('equals_to', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'label' => __('admin.form.select_model_type'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_model_type'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('result_datas', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [
                    
                ],
                'label' => __('admin.form.select_model_datas'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_model_datas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
                ]);
    }
}
