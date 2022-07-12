<?php

namespace Ludows\Adminify\Libs;

use Kris\LaravelFormBuilder\Form;

class FrontifyForms extends Form {
    public function buildForm() {}
    public function booting() {
        $this->setDefaultsSetting();
    }
    public function booted() {}
    public function __construct() {
        $this->booting();
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }
        $this->booted();
    }
    public function setDefaultsSetting() {
        $this->show_form_when_validated = true;
        $this->formOptions = ['method' => 'POST', 'url' => route('forms.validate')];
    }
    // protected function getTemplate() {
    //     return 'adminify::layouts.commons.forms.default';
    // }
}
