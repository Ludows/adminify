<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;


class CreateTemplates extends BaseForm
{
    public function buildForm()
    {
        $this->add('title', Field::TEXT, [
            'label_show' => false,
            'attr' => ['placeholder' =>  __('admin.form.title') ],
        ]);

        $this->addVisualEditor('content', [
            'label_show' => false
        ]);

        $this->addSubmit();
    }

}
