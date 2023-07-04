<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class DeleteCrud extends BaseForm
{
    public function __construct() {
        $newOptions = [
            'method' => 'DELETE',
            'url' => ''
        ];

        $this->formOptions = array_merge($this->formOptions, $newOptions);
    }
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('admin.form.delete') , 'attr' => ['class' => 'btn btn-danger mb-0']]);
    }
}
