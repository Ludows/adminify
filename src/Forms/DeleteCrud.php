<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class DeleteCrud extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('admin.form.delete') , 'attr' => ['class' => 'btn btn-danger']]);
    }
}
