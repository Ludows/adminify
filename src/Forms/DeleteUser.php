<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class DeleteUser extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => _i('admin.destroy') , 'attr' => ['class' => 'btn btn-danger']]);
    }
}
