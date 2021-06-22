<?php

namespace Ludows\Adminify\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title = '';
    public $modalClasses = '';
    public $id = '';
    public $btnSave = '';
    public $btnClear = '';
    public $modalDialogClasses = '';
    public $modalBodyClass = '';

    public function __construct($title = null, $modalClasses = null,$modalDialogClasses = '', $modalBodyClass = null, $id = null, $btnSave = null, $btnClear = null)
    {
        //
        $this->title = $title;
        $this->modalClasses = $modalClasses;
        $this->modalDialogClasses = $modalDialogClasses;
        $this->id = $id;
        $this->btnSave = $btnSave;
        $this->btnClear = $btnClear;
        $this->modalBodyClass = $modalBodyClass;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
