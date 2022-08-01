<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class UpdateForms extends BaseForm
{
    public function buildForm()
    {
        $this->compose('App\Adminify\Forms\CreateForms');
    }
}
