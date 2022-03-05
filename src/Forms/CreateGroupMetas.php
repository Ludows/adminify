<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use App\Adminify\Models\Category;
use App\Adminify\Models\Page;

class CreateGroupMetas extends Form
{
    public function buildForm()
    {
        // // Add fields here...
        // $hydratorCat = $this->hydrateSelect();
        // $hydratorPages = $this->hydrateSelectPage();
        // $m = $this->getModel();
        // $r = $this->getRequest();
        // $statuses = $this->getStatuses();
        // $enabled_features = get_site_key('enables_features');
        // $translations = $m->translations;

        $this
            ->add('title', Field::TEXT, [
                'label_show' => false,
                'attr' => ['placeholder' =>  __('admin.form.title') ],
            ]);
       
        $this->add('named_metas', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [],
                'label' => __('admin.form.named_metas'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_named_metas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('_select_model_type', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [
                    'class' => 'form-control js-select-model-type'
                ],
                'label' => __('admin.form.select_model_type'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_model_type'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('_results_model_datas', 'select2', [
                'empty_value' => '',
                'choices' => [],
                'selected' => '',
                'attr' => [
                    'class' => 'form-control js-result-model-type'
                ],
                'label' => __('admin.form.select_model_datas'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_model_datas'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ])
            ->add('user_id', 'hidden', [
                'value' => user()->id
            ])       
            ->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
