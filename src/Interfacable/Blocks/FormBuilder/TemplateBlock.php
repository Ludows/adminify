<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;

class TemplateBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Template Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        return $query;
    }
    public function handle() {

    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder.template';
    }
}
