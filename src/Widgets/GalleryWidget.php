<?php

namespace Ludows\Adminify\Widgets;

use Ludows\Adminify\Libs\EditorWidgetBase;

class GalleryWidget extends EditorWidgetBase {
    public function getIcon() {
        return 'ni ni-caps-small';
    }
    public function getName() {
        return __('admin.editor.widgets.gallery');
    }
    public function renderBlock() {
        return '<div '. $this->renderAttributes() .'></div>';
    }

    public function chooseTemplate() {
        $this->addChoose('chooseGallery', 'button', [
            'wrapper' => [
                'class' => 'col-12 mb-4',
            ],
            'attr' => [
                'class' => 'btn btn-default'
            ]
        ]);
    }


    public function addEditorAsset() {
        return [
            'js' => [
                asset('adminify') . '/back/js/editor/GalleryWidget.js'
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
                'div' => 'div',
                'article' => 'article',
                'section' => 'section',
            ],
            'selected' => 'div',
        ]);

        $this->addSettingControl('chooseGallery', 'lfm', [
            'wrapper' => [
                'class' => 'col-12 mb-4',
                'hidden' => 'hidden'
            ],
            'lfm_options' => [
                'disable_selection_preview' => true,
                'multiple' => true
            ]
        ]);

        $this->addSettingControl('cssClasses', 'text', [

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
