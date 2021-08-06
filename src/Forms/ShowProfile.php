<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class ShowProfile extends Form
{
    public function buildForm()
    {
        $this->add('topbar', 'checkbox', [
            'label' => __('admin.form.topbar'),
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
