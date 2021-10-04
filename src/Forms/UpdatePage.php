<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class UpdatePage extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreatePage');
    }
}
