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
            'label' => _i('admin.name'),
            'attr' => [],
        ]);
        $this->add('submit', 'submit', ['label' => _i('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
