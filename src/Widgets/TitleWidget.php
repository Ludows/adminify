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

    public function renderBlock($uuid) {
        return '<h1 class="'. $uuid .'" contenteditable="true">'. __('admin.editor.add_your_text') .'</h1>';
    }

    public function allowChildsNesting() {
        return false;
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
            'selected' => 'h1',
            'select2options' => [
                'multiple' => false
            ]
        ]);

        $this->addSettingControl('cssClasses', 'text', [

        ]);

        $this->addSettingControl('textTransform', 'select', [
            'choices' => [
                'none' => 'normal',
                'uppercase' => 'uppercase',
                'capitalize' => 'capitalize',
            ],
            'selected' => 'none'
        ]);

        $this->addSettingControl('font_family', 'select2', [
            'choices' => [],
            'selected' => '',
            'select2options' => [
                'multiple' => false
            ]
        ]);

        $this->addSettingControl('color', 'color', []);

        $this->addSettingControlWithBreakpoints('fontsize', 'number', [
            'attr' => [
                'min' => 1,
                'max' => 500
            ]
        ]);

        $this->addSettingControlWithBreakpoints('alignment', 'select', [
            'choices' => [
                'left' => 'left',
                'center' => 'center',
                'right' => 'right',
            ],
            'selected' => 'left'
        ]);

        $this->addSettingControlWithBreakpoints('line_height', 'number', [
            'attr' => [
                'min' => 1,
                'max' => 500
            ]
        ]);

        $this->addSettingControlWithBreakpoints('line_height_unit', 'select', [
            'choices' => [
                'px' => 'px',
                'rem' => 'rem',
                'em' => 'em',
                '%' => '%',
            ],
            'selected' => 'px'
        ]);

        $this->addSettingControlWithBreakpoints('fontsize_unit', 'select', [
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
