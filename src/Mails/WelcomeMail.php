<?php

namespace Ludows\Adminify\Mails;

use Ludows\Adminify\Libs\MailableBase;


class WelcomeMail extends MailableBase
{
    public function template() {
        return 'adminify::mails.welcome';
    }
}