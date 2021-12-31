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

    public function addEditorAsset() {
        return [
            'js' => [
                asset('adminify') . '/back/js/editor/TemplateWidget.js'
            ]
        ];
    }

    public function allowChildsNesting() {
        return false;
    }
    public function inject() {
        return [
            'tplModel' => adminify_get_class('Templates', ['app:adminify:models', 'app:models'], false),
            'tplRepo' => adminify_get_class('TemplatesRepository', ['app:adminify:repositories', 'app:repositories'], true),
        ];
    }
    public function canBePreviewed()
    {
        return true;
    }
    public function chooseTemplate() {

        $tpls = $this->tplModel::get();

        if($tpls->count() > 0) {
            $tpls = $tpls->pluck('title','id')->toArray();
        }
        else {
            $tpls = $tpls->all();
        }

        $this->addChoose('chooseTpl', 'select', [
            'choices' =>  array_merge(
                array('-1' => 'admin.editor.chooseTemplate'),
                $tpls
            ),
            'wrapper' => [
                'class' => 'col-12 mb-4',
            ],
            'attr' => [
                'data-widget' => 'ColumnWidget',
                'data-count' => 1
            ]
        ]);

    }
    public function showInSidebar() {
        return titled($this->request->singleParam) != 'Template';
    }
    public function buildSettings() {
        $this->addSettingControl('tag', 'select', [
            'choices' => [
                'div' => 'div',
                'article' => 'article',
                'section' => 'section',
            ],
            'selected' => 'div',
        ]);

        $this->addSettingControl('cssClasses', 'text', [

        ]);
    }
}
