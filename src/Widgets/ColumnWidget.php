<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class ColumnWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function showInSidebar() {
        return false;
    }
    public function getName() {
        return __('admin.editor.widgets.column');
    }
    public function renderBlock() {

        return '<div '. $this->renderAttributes() .'></div>';
    }
    public function allowContentEdition() {
        return false;
    }
    public function buildSettings() {
        $col_min = get_site_key('editor.patterns.column_minimal');
        $col_max = get_site_key('editor.patterns.column_maximal');
        $count = isset($this->config['count']) ? $this->config['count'] : 1;

        $this->addSettingControl('tag', 'select', [
            'choices' => [
                'div' => 'div',
                'article' => 'article',
                'section' => 'section',
            ],
            'selected' => 'div',
        ]);

        $this->addSettingControlWithBreakpoints('column_width', 'range', [
            'attr' => [
                'min' => $col_min,
                'max' => $col_max
            ],
            'value' => ( $col_max /  $count )
        ]);

        $this->addSettingControl('bgType', 'select', [
            'choices' => [
                'no-bg' => 'No Bg',
                'bg-color' => 'Background Color',
                'bg-image' => 'Background Image',
            ],
            'selected' => 'no-bg',
        ]);

        $this->addSettingControl('bgColor', 'color', [
            'wrapper' => [
                'hidden' => "hidden"
            ],
        ]);

        $this->addSettingControl('bgPositionImage', 'select', [
            'wrapper' => [
                'hidden' => "hidden"
            ],
            'choices' => [
                'center center' => 'center',
                'bottom left' => 'bottom left',
                'bottom right' => 'bottom right',
                'top left' => 'top left',
                'top right' => 'top right',
                'top' => 'top',
                'bottom' => 'bottom',
                'left' => 'left',
                'right' => 'right',
            ],
            'selected' => 'center center',
        ]);

        $this->addSettingControl('bgSizeImage', 'select', [
            'wrapper' => [
                'hidden' => "hidden"
            ],
            'choices' => [
                'cover' => 'cover',
                'contains' => 'contains',
                'other-control' => 'other control',
            ],
            'selected' => 'cover',
        ]);

        $this->addSettingControl('bgOtherSize', 'text', [
            'wrapper' => [
                'hidden' => "hidden"
            ],
        ]);

        $this->addSettingControl('bgImage', 'lfm', [
            'wrapper' => [
                'hidden' => "hidden"
            ],
        ]);



        $this->addSettingControl('cssClasses', 'text', [

        ]);
    }
}
