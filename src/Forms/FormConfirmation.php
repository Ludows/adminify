<?php

namespace Ludows\Adminify\Forms;

use Ludows\Adminify\Libs\BaseForm;
use App\Adminify\Models\Page;

class FormConfirmation extends BaseForm
{
    public function buildForm()
    {


        $this->add('type', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'wrapper' => [
                'id' => 'selectTypeBlock'
            ],
            'choices' => [
                'page' => __('admin.formbuilder.choice_page'),
                'redirect' => __('admin.formbuilder.choice_redirect'),
                'samepage' => __('admin.formbuilder.choice_samepage')
            ],
            'selected' => 'page',
            'label' => __('admin.formbuilder.type'),
            'select2options' => [
                'placeholder' => __('admin.formbuilder.type'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->add('redirect_url', 'url', [
            'wrapper' => [
                'class' => 'form-group d-none',
                'data-show-type' => 'redirect'
            ]
        ]);

        $this->addPages('page_id', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'label' => __('admin.formbuilder.page_id'),
            'wrapper' => [
                'class' => 'form-group',
                'data-show-type' => 'page'
            ],
            'select2options' => [
                'placeholder' => __('admin.formbuilder.page_id'),
                'multiple' => false,
                'width' => '100%'
            ]
        ]);

        $this->addJodit('content', [
            'wrapper' => [
                'class' => 'form-group d-none',
                'data-show-type' => 'samepage'
            ]
        ])
        ->addSubmit();
    }
}
