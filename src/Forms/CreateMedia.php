<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;


class CreateMedia extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('src', 'lfm', [
            'label_show' => false
        ])
        ->add('description', Field::TEXTAREA, [
            'label' => __('admin.form.description'),
        ])
        ->add('alt', Field::TEXT, [
            'label' => __('admin.form.alt'),
        ])
        ->add('user_id', 'hidden', [
            'value' => user()->id
        ])
        ->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
