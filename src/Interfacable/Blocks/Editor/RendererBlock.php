<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class RendererBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Renderer Block';
    }
    public function addToRender() {
        $r = $this->getRequest();
        return [
            'page' => $r->routeParameters[ $r->singleParam ]
        ];
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.renderer';
    }
}
