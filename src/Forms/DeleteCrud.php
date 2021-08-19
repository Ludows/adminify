<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class DeleteCrud extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('admin.form.delete') , 'attr' => ['class' => 'btn btn-danger']]);
    }
}
