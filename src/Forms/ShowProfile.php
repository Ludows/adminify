<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class ShowProfile extends Form
{
    public function buildForm()
    {
        $m = $this->getModel();

        $topbar = $m->getPreference('topbar');

        $this->add('user_id', 'hidden', [
            'value' => $m->id
        ]);

        $this->add('topbar', 'hidden', [
            'value' => 0
        ]);

        $this->add('topbar', 'checkbox', [
            'label' => __('admin.form.topbar'),
            'checked' =>  $topbar != null && $topbar == 1 ? true : false,
            'value' => $topbar != null && $topbar == 1 ? 0 : 1,
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
