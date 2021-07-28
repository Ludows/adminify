<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class ShowRegisterForm extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('name', 'text', [
            'label_show' => false,
            'label' => __('admin.form.name'),
            'attr' => [
                'placeholder' => __('admin.form.name')
            ]
        ]);
        $this->add('email', 'email', [
            'label_show' => false,
            'label' => __('admin.form.email'),
            'attr' => [
                'placeholder' => __('admin.form.email')
            ]
        ]);
        $this->add('password', 'repeated', [
            'type' => 'password',
            'second_name' => 'password_confirmation',
            'first_options' => [
                'label_show' => false,
                'label' => __('admin.form.password'),
                'attr' => [
                    'placeholder' => __('admin.form.password')
                ]
            ],
            'second_options' => [
                'label_show' => false,
                'label' => __('admin.form.password'),
                'attr' => [
                    'placeholder' => __('admin.form.confirm_password')
                ]
            ],
            
        ]);
        
        $this->add('submit', 'submit', [
            'label' => __('admin.form.submit'),
            'attr' => ['class' => 'btn btn-primary my-4'],
        ]);
        
    }
}
