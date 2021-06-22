<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class UpdatePost extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Forms\CreatePost');
    }
}
