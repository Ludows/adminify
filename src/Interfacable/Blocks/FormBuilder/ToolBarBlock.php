<?php

namespace Ludows\Adminify\Interfacable\Blocks\FormBuilder;

use Ludows\Adminify\Libs\InterfacableBlock;

class ToolBarBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Toolbar Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        return $query;
    }
    public function addToRender() {

        return [
            'isCreate' => $this->view->shared('isCreate')
        ];
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder.toolbar';
    }
}
