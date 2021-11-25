<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class RowWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.row');
    }
    public function getInlineToolbarRender() {}

    public function renderBlock($uuid) {
        return '';
    }

    public function getView() {
        return 'adminify::layouts.admin.interfacable.editor.renderers.form_title';
    }

    public function buildSettings() {

        $this->addSettingControl('tag', 'select', [
            'choices' => [
                'div' => 'div',
                'section' => 'section',
            ],
            'selected' => 'div',
        ]);

        $this->addSettingControl('bgType', 'select', [
            'choices' => [
                'no-bg' => 'No Bg',
                'bg-color' => 'Background Color',
                'bg-image' => 'Background Image',
            ],
            'selected' => 'no-bg',
        ]);

        $this->addSettingControl('bgPositionImage', 'select', [
            'choices' => [
                'center center' => 'center',
                'bottom left' => 'bottom left',
                'bottom right' => 'bottom right',
                'top left' => 'top left',
                'top right' => 'top right',
            ],
            'selected' => 'center center',
        ]);

        $this->addSettingControl('bgSizeImage', 'select', [
            'choices' => [
                'cover' => 'cover',
                'contains' => 'contains',
                'other-control' => 'other control',
            ],
            'selected' => 'cover',
        ]);

        $this->addSettingControl('bgOtherSize', 'text', [
            
        ]);

        $this->addSettingControl('bgImage', 'lfm', []);

        $this->addSettingControl('bgColor', 'color', [

        ]);

        $this->addSettingControl('cssClasses', 'text', [

        ]);
    }
}
