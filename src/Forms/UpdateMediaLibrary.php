<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class UpdateMediaLibrary extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('Ludows\Adminify\Forms\CreateMedia');
        $this->remove('src');
        $this->remove('submit');
    }
}
