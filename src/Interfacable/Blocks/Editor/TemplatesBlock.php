<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class TemplatesBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Templates Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        return $query;
    }
    public function addToRender() {
        return [];
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.templates';
    }
}
