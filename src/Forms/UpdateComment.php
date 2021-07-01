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
            'attr' => [
                'readonly' => 'readonly'
            ]
        ])
        ->add('name', Field::TEXT, [
            'attr' => [
                'readonly' => 'readonly'
            ]
        ])
        ->add('comment', Field::TEXTAREA, [])
        ->add('is_moderated', Field::CHECKBOX, [])
        ->add('submit', 'submit', ['label' => __('admin.update'), 'attr' => ['class' => 'btn btn-default']]);

    }
}
