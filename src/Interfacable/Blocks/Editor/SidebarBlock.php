<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class SidebarBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Sidebar Block';
    }
    public function addToRender() {
        $widgets = adminify_get_classes_by_folders([
            'app:widgets' , 'app:adminify:widgets'
        ]);
        return [
            'widgets' => $widgets
        ];
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.sidebar';
    }
}
