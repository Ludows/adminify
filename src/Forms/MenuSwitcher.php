<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;

use Ludows\Adminify\Models\Menu;

class MenuSwitcher extends Form
{
    public function buildForm()
    {
        // Add fields here...
        $this->add('menus', Field::SELECT, [
            'empty_value' => __('select.menu'),
            'label' => __('admin.form.menus'),
            'choices' =>[],
            'selected' => '',
            'attr' => [],
        ]);
        $this->add('submit', 'submit', ['label' => __('admin.form.select'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
