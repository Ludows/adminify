<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class ParagraphWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.paragraph');
    }
    public function renderBlock() {
        return '<p '. $this->renderAttributes() .'>'. __('admin.editor.add_your_text') . '</p>';
    }

    public function allowChildsNesting() {
        return false;
    }

    public function buildSettings() {

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
