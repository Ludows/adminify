<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class TemplateWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.template');
    }
    public function renderBlock() {

        return '<div '. $this->renderAttributes() .'></div>';
    }
    public function allowContentEdition() {
        return false;
    }
    public function chooseTemplate() {

        $this->addChoose('chooseTpl', 'select', [
            'wrapper' => [
                'class' => 'col-6 text-center mb-4',
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 1
            ]
        ]);

    }
    public function buildSettings() {}
}
