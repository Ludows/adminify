<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class TitleWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.title');
    }
    public function getInlineToolbarRender() {}

    public function renderBlock() {
        return '<h1 contenteditable="true">'. __('admin.editor.add_your_text') .'</h1>';
    }

    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.renderers.form_title';
    }

    public function addEditorAsset() {
        return [
            'css' => [],
            'js' => [
                asset('adminify') . '/back/js/editor/titleWidget.js'
            ]
        ];
    }
    public function buildSettings() {

        $this->addSettingControl('tag', 'select2', [
            'choices' => [
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6'
            ],
            'selected' => 'h1'
        ]);

        $this->addSettingControl('font_family', 'select2', [
            'choices' => [],
            'selected' => ''
        ]);

        $this->addSettingControl('color', 'color', []);

        $this->addSettingControl('fontsize', 'text', []);

        $this->addSettingControl('fontsize_unit', 'select', [
            'choices' => [
                'px' => 'px',
                'rem' => 'rem',
                'em' => 'em',
                '%' => '%',
            ],
            'selected' => 'px'
        ]);
    }
}
