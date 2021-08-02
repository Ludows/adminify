<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;


class CreateTemplates extends Form
{
    public function buildForm()
    {
        $this->add('content', 'laraberg', [
            'label' => __('admin.form.content'),
            'label_show' => false
        ]);

        $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }

}
