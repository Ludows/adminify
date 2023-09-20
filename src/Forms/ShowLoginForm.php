<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;

class ShowLoginForm extends BaseForm
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('email', 'email', [
            'label_show' => false,
            'label' => __('admin.form.email'),
            'attr' => [
                'placeholder' => __('admin.form.email')
            ]
        ]);
        $this->add('password', 'password', [
            'label_show' => false,
            'label' => __('admin.form.password'),
            'attr' => [
                'placeholder' => __('admin.form.password')
            ]
        ]);
        $this->add('remember', 'checkbox', [
            'label' => __('admin.form.remember'),
            'wrapper' => ['class' => 'custom-control custom-control-alternative custom-checkbox'],
            'attr' => ['class' => 'custom-control-input'],
            'label_attr' => ['class' => 'custom-control-label text-muted'],
        ]);
        $this->add('submit', 'submit', [
            'label' => __('admin.form.submit'),
            'attr' => ['class' => 'btn btn-primary my-4'],
        ]);
        
    }
}
