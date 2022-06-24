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
            ->add('key', Field::TEXT, [
                'label' => __('admin.form.key'),
            ])
            ->add('text', 'jodit', [
                'label' => __('admin.form.text'),
            ]);
            $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
