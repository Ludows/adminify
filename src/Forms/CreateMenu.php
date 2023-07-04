<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class CreateMenu extends BaseForm
{
    public function __construct() {
        $newOptions = [
            'method' => 'POST',
            'url' => route('menus.store')
        ];

        $this->formOptions = array_merge($this->formOptions, $newOptions);
    }
    public function buildForm()
    {
        // Add fields here...
        // Add fields here...
        $this->add('title', Field::TEXT, [
            'label' => __('admin.form.name'),
            'attr' => [],
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
