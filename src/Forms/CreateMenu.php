<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CreateMenu extends Form
{
    public function buildForm()
    {
        // Add fields here...
        // Add fields here...
        $this->add('title', Field::TEXT, [
            'label' => __('admin.name'),
            'attr' => [],
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
