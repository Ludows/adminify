<?php

namespace Ludows\Adminify\Mails;

use Ludows\Adminify\Libs\MailableBase;

use App\Adminify\Models\Forms;

class FormEntriesListingMail extends MailableBase
{

    public function vars() {
        return [];
    }
   
    public function template() {
        return 'adminify::mails.form_entries';
    }
   
}
