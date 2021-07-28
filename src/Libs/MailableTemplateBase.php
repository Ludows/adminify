<?php

namespace Ludows\Adminify\Libs;

use Spatie\MailTemplates\TemplateMailable;
use Spatie\MailTemplates\MailTemplateInterface;


class MailableTemplateBase extends TemplateMailable
{
    public static function getHtmlTemplate() {
        return '';
    }
    public static function getSubject() {
        return '';
    }
}