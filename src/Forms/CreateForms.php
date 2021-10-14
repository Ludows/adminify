<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
class CreateForms extends Form
{
    public function buildForm()
    {
        $this->add('user_id', 'hidden', [
            'value' => user()->id
        ]);
        $this->add('title', 'text', [
            'attr' => [
                'placeholder' => __('adminify.formbuilder.form')
            ]
        ]);
        $this->add('fields', 'collection', [
            'type' => 'form',
            'options' => [    // these are options for a single type
                'class' => 'App\Adminify\Forms\CreateFields',
                'label' => false,
                'items' => [],
                'template' => 'adminify::layouts.admin.interfacable.formbuilder.card-group'
            ]
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
