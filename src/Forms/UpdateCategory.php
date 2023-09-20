<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class UpdateCategory extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreateCategory');
    }
}
