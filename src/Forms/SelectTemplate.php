<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class SelectTemplate extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('items', 'select2', [
            'label' => __('admin.form.items'),
            'attr' => [
            ]
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.add') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
