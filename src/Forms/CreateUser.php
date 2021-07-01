<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CreateUser extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
            ->add('name', Field::TEXT, [])
            ->add('avatar', 'lfm', [])
            ->add('email', Field::EMAIL, [])
            ->add('password', 'generatorPassword', []);

        $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);

    }
}
