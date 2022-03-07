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

        $this->add('_conditions', 'collection', [
            'type' => 'form',
            'prototype' => true, 
            'label_show' => false,
            'prefer_input' => true,
            'options' => [    // these are options for a single type
                'class' => 'App\Adminify\Forms\ConditionnalShowMetas',
                'label' => false,
            ]
        ]);

        $this->add('_addCondition', 'button', [
            "attr" => [
                "class" => "btn btn-default"
            ],
            "label" => __('admin.form.addConditionnalShow')
        ]);
        $this->add('user_id', 'hidden', [
            'value' => user()->id
        ])       
        ->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
