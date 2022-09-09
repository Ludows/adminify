<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class CopyCrud extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('admin.form.copy') , 'attr' => ['class' => 'btn btn-primary mb-0']]);
    }
}
