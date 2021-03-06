<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class SetItemsToMenu extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('items', 'select2', [
            'label' => __('admin.form.items'),
            'attr' => [
                'multiple' => 'multiple'
            ]
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.send') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
