<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class TitleWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getNamedBlock() {
        return __('admin.editor.widgets.title');
    }

    public function getInlineToolbarRender() {}
    public function renderBlock() {}
    public function renderSettings() {}
}