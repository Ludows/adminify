<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
class CreateForms extends Form
{
    public function buildForm()
    {
        $m = $this->getModel();
        $this->add('user_id', 'hidden', [
            'value' => user()->id
        ]);
        $this->add('title', 'text', [
            'required' => true,
            'attr' => [
                'placeholder' => __('adminify.formbuilder.form')
            ]
        ]);

        $this->add('model_class', 'select2', [
            'required' => true,
            'empty_value' => '',
            'attr' => [
                'placeholder' => __('adminify.formbuilder.model_class')
            ],
            'select2options' => [
                'placeholder' => __('admin.formbuilder.model_class'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);
        // $this->add('fields', 'collection', [
        //     'type' => 'form',
        //     'prefer_input' => true,
        //     'label_show' => false,
        //     'wrapper' => false,
        //     'data' => empty($m) ? [] : $m->fields,
        //     'options' => [    // these are options for a single type
        //         'class' => 'App\Adminify\Forms\CreateFields',
        //         'label' => false,
        //         'items' => [],
        //         'template' => 'adminify::layouts.admin.interfacable.formbuilder.card-group'
        //     ]
        // ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
