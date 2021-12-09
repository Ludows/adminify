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

    public function renderBlock() {

        return '<div '. $this->renderAttributes() .'>'. $this->getNestableHtml() .'</div>';
    }
    public function allowContentEdition() {
        return false;
    }
    public function chooseTemplate() {

        $this->addChoose('1-col', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center mb-4',
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 1
            ]
        ]);

        $this->addChoose('2-cols', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center mb-4'
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 2
            ]
        ]);

        $this->addChoose('3-cols', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center mb-4'
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 3
            ]
        ]);

        $this->addChoose('4-cols', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center mb-4'
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 4
            ]
        ]);

        $this->addChoose('5-cols', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center'
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 5
            ]
        ]);

        $this->addChoose('6-cols', 'button', [
            'wrapper' => [
                'class' => 'col-6 text-center'
            ],
            'attr' => [
                'class' => 'btn btn-lg btn-primary',
                'data-widget' => 'ColumnWidget',
                'data-count' => 6
            ]
        ]);

        // dd($this->chooseTemplate);
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

        $this->addSettingControlWithBreakpoints('rowDirection', 'select', [
            'choices' => [
                'row' => 'row',
                'row-reverse' => 'row reverse',
                'column' => 'column',
                'column-reverse' => 'column reverse',
            ],
            'selected' => 'row',
        ]);

        $this->addSettingControlWithBreakpoints('contentPosition', 'select', [
            'choices' => [
                'flex-start' => 'start',
                'center' => 'center',
                'flex-end' => 'end',
                'space-between' => 'between',
                'space-around' => 'around',
            ],
            'selected' => 'flex-start',
        ]);

        $this->addSettingControlWithBreakpoints('contentAlignPosition', 'select', [
            'choices' => [
                'flex-start' => 'start',
                'center' => 'center',
                'flex-end' => 'end',
                'space-between' => 'between',
                'space-around' => 'around',
            ],
            'selected' => 'flex-start',
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
