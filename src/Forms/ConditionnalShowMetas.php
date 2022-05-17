<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class ConditionnalShowMetas extends Form
{
    public function buildForm()
    {

        $models = adminify_get_classes_by_folders(['app:models', 'app:adminify:models']);
        $choices_typed_data = [
            'content_type_model' => __('admin.form.chooseContentTypeModel')
        ];

        $excludes = get_site_key('metas.excludes');

        foreach ($models as $key => $value) {
            # code...
            if(!in_array($key, $excludes)) {
                $k = lowercase($key);
                $choices_typed_data[ 'model:'.$k ] = __('admin.model.'.$k);
            }

        }

        // lowercase();

         $this->add('typed_data', 'select', [
                'empty_value' => __('admin.form.select_entity'),
                'choices' => $choices_typed_data,
                'required' => true,
                'selected' => '',
                'attr' => [
                    'class' => 'form-control js-typed-data'
                ],
                'label' => __('admin.form.named_metas'),
                'force_js' => true,
                'force_sibling' => true,
                'select2options' => [
                    'placeholder' => __('admin.form.select_named_metas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('equals_to', 'select', [
                'empty_value' => '',
                'required' => true,
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
            ->add('result_datas', 'select', [
                'empty_value' => __('admin.form.select_entry'),
                'choices' => [],
                'required' => true,
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

            $this->add('_removeCondition', 'button', [
                "attr" => [
                    "class" => "btn btn-danger js-remove-prototype",
                ],
                "label" => __('admin.form.removeConditionnalShow')
            ]);
    }
}
