<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class ShowResetForm extends BaseForm
{
    public function buildForm()
    {
        $r = $this->getRequest();
        $token = $r->route()->parameter('token');
        $existToken = $r->exists('token');

        if($existToken) {
            $this->add('token', 'hidden', [
                'value' => $token
            ]);
        }
        
        // Add fields here...
        $this->add('email', 'email', [
            'label_show' => false,
            'label' => __('admin.form.email'),
            'value' => $r->email,
            'attr' => [
                'placeholder' => __('admin.form.email')
            ]
        ]);

        if($existToken) {
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
        }

        $this->add('submit', 'submit', [
            'label' => __('admin.form.submit'),
            'attr' => ['class' => 'btn btn-primary my-4'],
        ]);
        
    }
}
