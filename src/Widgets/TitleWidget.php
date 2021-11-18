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
    public function addEditorAsset() {
        return [
            'css' => [],
            'js' => [
                asset('adminify') . '/back/js/editor/titleWidget.js'
            ]
        ];
    }
    public function renderSettings() {

        // $this->addSettingControl('')


    }
}
