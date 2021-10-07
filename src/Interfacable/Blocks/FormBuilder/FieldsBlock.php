<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;

use Kris\LaravelFormBuilder\Field;
class FieldsBlock extends InterfacableBlock {
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

        return [
            'fields' => []
        ]
    }
}
