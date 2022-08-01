<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
class CreateForms extends BaseForm
{
    public function buildForm()
    {
        $classes = adminify_get_classes_by_folder('app:forms:front');
        $m = $this->getModel();
        $this->addUserId('user_id', []);

        $this->add('title', 'text', [
            'required' => true,
            'attr' => [
                'placeholder' => __('adminify.formbuilder.form')
            ]
        ]);

        $this->add('model_class', 'select2', [
            'required' => true,
            'empty_value' => '',
            'choices' => !empty($classes) ? array_flip($classes) : [],
            'selected' => !empty($m) ? $m->model_class : '',
            'attr' => [
                'placeholder' => __('adminify.formbuilder.model_class')
            ],
            'select2options' => [
                'placeholder' => __('admin.formbuilder.model_class'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);
        
        $this->addSubmit();
    }
}
