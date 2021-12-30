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
    public function inject() {
        return [
            'tplModel' => adminify_get_class('Templates', ['app:adminify:models', 'app:models'], true),
            'tplRepo' => adminify_get_class('TemplatesRepository', ['app:adminify:repositories', 'app:repositories'], true),
        ];
    }
    public function chooseTemplate() {

        $tpls = $this->tplModel->all()->pluck('id', 'title');

        $this->addChoose('chooseTpl', 'select', [
            'choices' => $tpls,
            'wrapper' => [
                'class' => 'col-12 mb-4',
            ],
            'attr' => [
                'data-widget' => 'ColumnWidget',
                'data-count' => 1
            ]
        ]);

    }
    public function buildSettings() {}
}
