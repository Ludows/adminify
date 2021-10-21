<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;

use Kris\LaravelFormBuilder\Field;
use Illuminate\Support\Arr;


class FieldsBlock extends InterfacableBlock {
    public function __construct() {
        parent::__construct();
        $this->excludes = [
            'entity',
            'form',
            'submit',
            'image',
            'choice',
            'radio',
            'select',
            'checkbox'
        ];
    }
    public static function getNamedBlock() {
        return 'Fields Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        return $query;
    }
    public function handle() {

    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder.fields';
    }

    public function addToRender() {

        $reflexion = new \ReflectionClass(Field::class);
        $constants = $reflexion->getConstants();
        $configBuilder = array_keys(config('laravel-form-builder.custom_fields'));

        $concat =  Arr::flatten(array_merge($constants, $configBuilder));

        // gestion

        $types_choices = [
            'radio',
            'select:single',
            'select:multiple',
            'checkbox'
        ];

        if(in_array('choice', $concat)) {
            foreach ($types_choices as $types_choice) {
                # code...
                $concat[] = 'choice.'.$types_choice;
            }
        }


        $concat = array_filter($concat, function($v) {
            if(!in_array($v, $this->excludes)) {
                return $v;
            }
        });

        return [
            'fields' => $concat
        ];
    }
}
