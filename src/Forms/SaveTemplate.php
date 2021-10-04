<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class SaveTemplate extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreateTemplates');

        $fieldContent = $this->getField('content'); 

        $this->modify('content', 'hidden');

    }
}