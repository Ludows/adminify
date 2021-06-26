<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class UpdateUser extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('Ludows\Adminify\Forms\CreateUser');
    }
}
