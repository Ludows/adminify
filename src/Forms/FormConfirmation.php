<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Adminify\Models\Page;

class FormConfirmation extends Form
{
    public function buildForm()
    {

        $hydrator_pages = $this->hydrateSelectPage();

        $this->add('type', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
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

        $this->add('page_id', 'select2', [
            'empty_value' => '',
            'withCreate' => false,
            'modal' => '', // simple include
            'choices' => $hydrator_pages['pages'],
            'selected' => $hydrator_pages['selected'],
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

        $this->add('content', 'summernote', [
            'wrapper' => [
                'class' => 'form-group d-none',
                'data-show-type' => 'samepage'
            ]
        ])
        ->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);        
    }
    public function hydrateSelectPage() {
        $pages = '';
        $hasModel = $this->getModel();
        // dd($hasModel);
        $pages = Page::get()->pluck('title' ,'id');
        $selecteds = '';

        if(!empty($hasModel->page_id) && !is_array($hasModel)) {
            // on a une selection
            $selecteds = $hasModel->page_id;
        }

        return [ 'pages' => $pages->all(), 'selected' => $selecteds];
    }
}
