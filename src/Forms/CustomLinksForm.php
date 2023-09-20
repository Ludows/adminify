<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use Kris\LaravelFormBuilder\Field;

class CustomLinksForm extends BaseForm
{
    public function buildForm()
    {
        
        // $this->add('menus', Field::SELECT, [
        //     'empty_value' => __('select.menu'),
        //     'label' => __('admin.form.menus'),
        //     'choices' => $choices,
        //     'selected' => '',
        //     'attr' => [],
        // ]);
        // $this->addSubmit(['label' => __('admin.form.select')]);
    }
}
