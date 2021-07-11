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
            ->add('name', Field::TEXT, [
                'label' => __('admin.form.name'),
            ])
            ->add('avatar', 'lfm', [
                'label' => __('admin.form.avatar'),
            ])
            ->add('email', Field::EMAIL, [
                'label' => __('admin.form.email'),
            ])
            ->add('password', 'generatorPassword', [
                'label' => __('admin.form.password'),
            ]);

        $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);

    }
}
