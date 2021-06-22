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
            'label' => 'Name',
            'attr' => [],
        ]);
        $this->add('submit', 'submit', ['label' => 'Créer', 'attr' => ['class' => 'btn btn-default']]);
    }
}
