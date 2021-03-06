<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;


class CreateTemplates extends Form
{
    public function buildForm()
    {
        $this->add('title', Field::TEXT, [
            'label_show' => false,
            'attr' => ['placeholder' =>  __('admin.form.title') ],
        ]);
        $this->add('content', 'visual_editor', [
            'label' => __('admin.form.content'),
            'label_show' => false
        ]);

        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }

}
