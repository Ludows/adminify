<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class SetItemsToMenu extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('items', 'select2', [
            'label' => false,
            'attr' => [
                'multiple' => 'multiple'
            ]
        ]);
        $this->add('submit', 'submit', ['label' => _i('admin.send') , 'attr' => ['class' => 'btn btn-default']]);

    }
}
