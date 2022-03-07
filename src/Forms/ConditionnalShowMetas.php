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
                'empty_value' => __('admin.form.select_entity'),
                'choices' => [
                    'model' => __('admin.form.chooseEntity'),
                    'content_type_model' => __('admin.form.chooseContentTypeModel')
                ],
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
                'choices' => [
                    '==' => __('admin.form.equal'),
                    '!=' => __('admin.form.unlike')
                ],
                'selected' => '',
                'label' => __('admin.form.select_equals_to'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_equals_to'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('result_datas', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [
                    'class' => 'form-control js-select-value'
                ],
                'label' => __('admin.form.select_result_datas'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_result_datas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
                ]);
    }
}
