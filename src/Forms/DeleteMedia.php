<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class DeleteMedia extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('submit', 'submit', ['label' => __('suppress.medias') , 'attr' => ['class' => 'btn btn-danger']]);
    }
}
