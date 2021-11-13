<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class EditorManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor';
    }

    public function blocks() {
        return [
            \App\Adminify\Interfacable\Blocks\Editor\SidebarBlock::class,
            \App\Adminify\Interfacable\Blocks\Editor\RendererBlock::class
        ];
    }
}
