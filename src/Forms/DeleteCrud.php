<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class DeleteCrud extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('admin.destroy') , 'attr' => ['class' => 'btn btn-danger']]);
    }
}
