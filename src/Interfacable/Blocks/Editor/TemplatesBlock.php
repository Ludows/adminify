<?php

namespace Ludows\Adminify\Interfacable\Blocks\Editor;

use Ludows\Adminify\Libs\InterfacableBlock;

class TemplatesBlock extends InterfacableBlock {
    public static function getNamedBlock() {
        return 'Templates Block';
    }
    public function inject() {
        return [
            'mdlTemplate' => app( adminify_get_class('Templates', ['app:models', 'app:adminify:models'], false) ),
        ];
    }
    public function query() {
        return $this->mdlTemplate->all()->toArray();
    }
    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.templates';
    }
}
