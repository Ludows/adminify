<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class UpdateComment extends Form
{
    public function buildForm()
    {
        // Add fields here...

        $this
        ->add('email', Field::TEXT, [
            'label' => __('admin.form.email'),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ])
        ->add('name', Field::TEXT, [
            'label' => __('admin.form.name'),
            'attr' => [
                'readonly' => 'readonly'
            ]
        ])
        ->add('comment', Field::TEXTAREA, [
            'label' => __('admin.form.comment'),
        ])
        ->add('is_moderated', Field::CHECKBOX, [
            'label' => __('admin.form.is_moderated'),
        ])
        ->add('submit', 'submit', ['label' => __('admin.update'), 'attr' => ['class' => 'btn btn-default']]);

    }
}
