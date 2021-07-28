<?php

namespace Ludows\Adminify\Mails;

use Ludows\Adminify\Libs\MailableTemplateBase;

class WelcomeMail extends MailableTemplateBase
{
    /** @var string */
    public $name;
    
    /** @var string */
    public $email;

    public function __construct(User $user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public static function getHtmlTemplate() {
        return '<h1>Hello, {{ name }}!</h1>';
    }
    public static function getSubject() {
        return 'Welcome Mail';
    }
    
    public function getHtmlLayout(): string
    {
        /**
         * In your application you might want to fetch the layout from an external file or Blade view.
         * 
         * External file: `return file_get_contents(storage_path('mail-layouts/main.html'));`
         * 
         * Blade view: `return view('mailLayouts.main', $data)->render();`
         */
        
        return '<header>Site name!</header>{{{ body }}}<footer>Copyright 2018</footer>';
    }
}