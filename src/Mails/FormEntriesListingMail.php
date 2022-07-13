<?php

namespace Ludows\Adminify\Mails;

use Ludows\Adminify\Libs\MailableTemplateBase;

use App\Adminify\Models\Forms;

class FormEntriesListingMail extends MailableTemplateBase
{
    // /** @var array */
    // public function __construct($Forms)
    // {
    //     $this->form = $Forms;
    // }

    public static function getHtmlTemplate() {
        return '<h1>@todo</h1>';
    }
    public static function getSubject() {
        return 'New Entry for Form';
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
