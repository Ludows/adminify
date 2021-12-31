<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class ImageWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.image');
    }
    public function renderBlock() {
        return '<figure '. $this->renderAttributes() .'><img class="img-fluid" src="" alt=""></figure>';
    }

    public function addEditorAsset() {
        return [
            'js' => [
                asset('adminify') . '/back/js/editor/ImageWidget.js'
            ]
        ];
    }

    public function allowChildsNesting() {
        return false;
    }

    public function allowContentEdition() {
        return false;
    }

    public function buildSettings() {

        $this->addSettingControl('tag', 'select', [
            'choices' => [
                'figure' => 'figure',
                'div' => 'div',
                'article' => 'article',
            ],
            'selected' => 'figure'
        ]);

        $this->addSettingControl('imageSrc', 'lfm', [

        ]);

        $this->addSettingControl('cssClasses', 'text', [

        ]);

        $this->addSettingControlWithBreakpoints('opacity', 'range', [
            'attr' => [
                'min' => 0,
                'max' => 100
            ],
            'value' => 100
        ]);

        $this->addSettingControlWithBreakpoints('radius', 'range', [
            'attr' => [
                'min' => 0,
                'max' => 100
            ],
            'value' => 100
        ]);

        

        $this->addSettingControlWithBreakpoints('alignment', 'select', [
            'choices' => [
                'left' => 'left',
                'center' => 'center',
                'right' => 'right',
            ],
            'selected' => 'left'
        ]);

    }
}
