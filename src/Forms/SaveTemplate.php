<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class SaveTemplate extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreateTemplates');

        $fieldContent = $this->getField('content'); 

        $this->modify('content', 'hidden');

    }
}