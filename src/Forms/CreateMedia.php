<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;


class CreateMedia extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('title', Field::TEXT, [])
        ->add('description', Field::TEXTAREA, [])
        ->add('alt', Field::TEXT, [])
        ->add('src', 'lfm', [
            'label_show' => false
        ])
        ->add('submit', 'submit', ['label' => _i('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
