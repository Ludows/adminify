<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class RendererBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Renderer Block';
    }
    public function query() {
        $r = $this->getRequest();
        $query = null;
        return $query;
    }
    public function addToRender() {
        
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.renderer';
    }
}
