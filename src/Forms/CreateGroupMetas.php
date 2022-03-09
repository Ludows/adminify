<?php

namespace Ludows\Adminify\Forms;

use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\Field;
use Illuminate\Support\Facades\Route;


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

        $arrayOfRoutesNames = array();
        $selectedsRoutes = array();
        $routeCollection = Route::getRoutes()->get();
        $excludes = get_site_key('metas.excludesOn');
        $m = $this->getModel();
        $routesInDb = [];

        if(!empty($m)) {
            $routesInDb = explode(',',$m->views_name);
        }

        // dd($this->getModel());

        foreach ($routeCollection as $route) {
            # code...
            $routeName = $route->getName();
            if(startsWith($route->uri, 'admin') && !containsIn($routeName, $excludes) ) {
                $arrayOfRoutesNames[$routeName] = __('admin.form.routes.'.$routeName);
                if(!empty($m) && in_array($routeName, $routesInDb)) {
                    $selectedsRoutes[] = $routeName;
                }
            }
        }

        // dd($this->getRequest());

        $this
            ->add('title', Field::TEXT, [
                'label_show' => false,
                'attr' => ['placeholder' =>  __('admin.form.title') ],
            ]);

        $this
            ->add('named_class', 'select2', [
                'empty_value' => __('admin.form.select_named_class'),
                'choices' => adminify_get_classes_by_folders(['app:metas', 'app:adminify:metas']),
                'selected' => !empty($m) ? $m->named_class : '',
                'label' => __('admin.form.select_named_class'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_named_class'),
                    'multiple' => false,
                    'width' => '100%'
                ]
            ]);

        $this
            ->add('views_name', 'select2', [
                'empty_value' => __('admin.form.select_routes'),
                'choices' => $arrayOfRoutesNames,
                'selected' => $selectedsRoutes,
                'attr' => [
                    'multiple' => 'multiple'
                ],
                'label' => __('admin.form.select_routes'),
                'select2options' => [
                    'placeholder' => __('admin.form.select_routes'),
                    'multiple' => true,
                    'width' => '100%'
                ]
            ]);

        // $this->add('_conditions', 'collection', [
        //     'type' => 'form',
        //     'prototype' => true,
        //     'label_show' => true,
        //     'label' => __('admin.form.conditions'),
        //     'prefer_input' => true,
        //     'wrapper' => [
        //         'class' => 'form-group js-conditions-block'
        //     ],
        //     'options' => [    // these are options for a single type
        //         'class' => 'App\Adminify\Forms\ConditionnalShowMetas',
        //         'label' => false,
        //     ]
        // ]);

        // $conditions = $this->getField('_conditions');


        // $this->add('_addCondition', 'button', [
        //     "attr" => [
        //         "class" => "btn btn-default js-add-prototype",
        //         "data-prototype" => form_row($conditions->prototype())
        //     ],
        //     "label" => __('admin.form.addConditionnalShow')
        // ]);

        // $this->add('_conditionsOr', 'collection', [
        //     'type' => 'form',
        //     'prototype' => true,
        //     'label_show' => true,
        //     'label' => __('admin.form.conditionsOr'),
        //     'prefer_input' => true,
        //     'wrapper' => [
        //         'class' => 'form-group js-conditions-block-or'
        //     ],
        //     'options' => [    // these are options for a single type
        //         'class' => 'App\Adminify\Forms\ConditionnalShowMetas',
        //         'label' => false,
        //     ]
        // ]);

        // $conditions = $this->getField('_conditionsOr');


        // $this->add('_addConditionOr', 'button', [
        //     "attr" => [
        //         "class" => "btn btn-default js-add-prototype-or",
        //         "data-prototype" => form_row($conditions->prototype())
        //     ],
        //     "label" => __('admin.form.addConditionnalShow')
        // ]);
        $this->add('uuid', 'hidden', [
            'value' => 'metabox-'.uuid(15)
        ]);

        $this->add('user_id', 'hidden', [
            'value' => user()->id
        ])
        ->add('submit', 'submit', ['label' => __('admin.form.create'), 'attr' => ['class' => 'btn btn-default']]);
    }
}
