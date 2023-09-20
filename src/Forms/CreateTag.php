<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;


class CreateTag extends BaseForm
{
    public function buildForm()
    {
            $this->add('title', Field::TEXT, [
                'label' => __('admin.form.title'),
            ]);

            $this->addSubmit();
            
    }

}
