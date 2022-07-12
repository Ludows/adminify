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
        parent::__construct();
        $this->booting();
        $this->booted();
    }
    public function setDefaultsSetting() {
        $this->show_form_when_validated = true;
    }
    protected function getTemplate() {
        return 'adminify::layouts.commons.forms.default';
    }
}
