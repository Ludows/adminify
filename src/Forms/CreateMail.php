<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;

class CreateMail extends Form
{
    public function buildForm()
    {

        //@todo
        $this->add('mailable', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'choices' => $hydratorCat['categories'],
            'selected' => $hydratorCat['selected'],
            'attr' => ['multiple' => 'multiple'],
            'label' => __('admin.form.categories_id'),
            'select2options' => [
                'placeholder' => __('admin.select_category'),
                'multiple' => true,
                'width' => '100%'
            ]
        ]);

        $this->add('subject', 'text', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.subject')],
        ]);

        $this->add('html_template', 'summernote', [
            'label_show' => false,
            'attr' => ['placeholder' => __('admin.form.html_template')],
        ]);
        
    }
}
