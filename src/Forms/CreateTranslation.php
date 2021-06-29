<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

class CreateTranslation extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this
            ->add('key', Field::TEXT, [])
            ->add('text', Field::TEXT, []);
            $this->add('submit', 'submit', ['label' => _i('admin.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
