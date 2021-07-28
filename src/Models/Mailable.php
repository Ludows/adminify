<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicMail;
class Mailable extends ClassicMail
{

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MailsTable::class;
    }
}
