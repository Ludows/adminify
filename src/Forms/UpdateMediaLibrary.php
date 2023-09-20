<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class UpdateMediaLibrary extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->compose('App\Adminify\Forms\CreateMedia');
        $this->remove('src');
        $this->remove('submit');
    }
}
