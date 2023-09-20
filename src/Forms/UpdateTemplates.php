<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;


class UpdateTemplates extends BaseForm
{
    public function buildForm()
    {
        $this->add('title', Field::TEXT, [
            'label_show' => false,
            'attr' => ['placeholder' =>  __('admin.form.title') ],
        ]);
        
        $this->add('content', 'laraberg', [
            'label' => __('admin.form.content'),
            'label_show' => false
        ]);

        $this->add('submit', 'submit', ['label' => __('admin.form.update'), 'attr' => ['class' => 'btn btn-default']]);
    }

}
