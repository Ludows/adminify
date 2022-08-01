<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

use Ludows\Adminify\Models\Menu;

class MenuSwitcher extends BaseForm
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
        $this->addSubmit(['label' => __('admin.form.select')]);
    }
}
