<?php

namespace Ludows\Adminify\Libs;

use Error;
// use Spatie\MailTemplates\TemplateMailable;
// use Spatie\MailTemplates\MailTemplateInterface;
use Snowfire\Beautymail\Beautymail;

class MailableBase extends Beautymail
{
    public function booting() {}
    public function booted() {}
    public function __construct() {
        $this->booting();
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }
        $this->data( $this->vars() );
        $this->booted();
    }
    public function toConstructor($key, $value) {
        $this->{$key} = $value;
        return $this;
    }
    public function data($array = []) {
        $data = array_merge($this->settings, $array);
        $this->settings = $data;
        return $this;
    }
    public function template() {
        return '';
    }
    public function vars() {
        return [];
    }
}
