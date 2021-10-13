<?php

namespace Ludows\Adminify\Interfacable;

use Ludows\Adminify\Libs\InterfacableManager;

class FormBuilderManager extends InterfacableManager {
    public function getView() {
        return 'adminify::layouts.admin.interfacable.formbuilder';
    }

    public function blocks() {
        return [
            \App\Adminify\Interfacable\Blocks\FormBuilder\FormBlock::class,
            \App\Adminify\Interfacable\Blocks\FormBuilder\FieldsBlock::class,
        ];
    }
}
