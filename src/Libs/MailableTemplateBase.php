<?php

namespace Ludows\Adminify\Libs;

use Error;
use Spatie\MailTemplates\TemplateMailable;
use Spatie\MailTemplates\MailTemplateInterface;

class MailableTemplateBase extends TemplateMailable
{
    public function booting() {}
    public function booted() {}
    public function __construct() {
        $this->booting();
        if (is_callable('parent::__construct')) {
            parent::__construct();
        }
        $this->booted();
    }
    public function toConstructor($key, $value) {
        $this->{$key} = $value;
        return $this;
    }
    public static function getHtmlTemplate() {
        return '';
    }
    public static function getSubject() {
        return '';
    }
}
