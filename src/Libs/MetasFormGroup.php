<?php

namespace Ludows\Adminify\Libs;

use Kris\LaravelFormBuilder\Form;

class MetasFormGroup extends Form {

    public $allow_filtering = true;
    public function getMetaboxTitle() {
        return '';
    }
    public function getTypeField() {
        return 'collection';
    }
    public function getDefaults() {
        return [
            'type' => 'form',
            'prototype' => true,
            'label_show' => true,
            'prefer_input' => true,
            'wrapper' => [
                'class' => 'form-group js-metabox-show p-4 rounded-lg shadow bg-white mb-3'
            ],
            'options' => [    // these are options for a single type
                'label' => false,
            ]
        ];
    }
    public function showGroup( $model = []) {
        return false;
    }
}
