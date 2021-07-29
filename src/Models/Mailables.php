<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicMail;
class Mailables extends ClassicMail
{

    public function getTableListing() {
        return \Ludows\Adminify\Tables\MailsTable::class;
    }
}
