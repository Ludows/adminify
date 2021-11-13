<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class TopBarEditor extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'TopBar Editor Block';
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
        return 'adminify::layouts.admin.interfacable.editor.topbar';
    }
}
