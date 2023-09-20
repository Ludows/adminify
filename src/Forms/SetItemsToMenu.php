<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class SetItemsToMenu extends BaseForm
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
